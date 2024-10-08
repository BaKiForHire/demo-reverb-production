<?php

namespace App\Http\Controllers;

use App\Events\UserTierEvaluationFailed;
use App\Events\UserUpgradedTier;
use App\Models\User;
use App\Models\UserTierKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TierEvaluationController extends Controller
{
    /**
     * Check if the user meets criteria for the specified tier and award it if eligible.
     */
    public function evaluate(Request $request)
    {
        $user = Auth::user();

        if (!$user instanceof User) {
            return response()->json(['message' => 'User not found.'], 404);
        }

        $tiers = $request->input('tier_ids', []);
        $awardedTiers = [];

        foreach ($tiers as $tierId) {
            // Fetch the keys required for the specified tier using the pivot table
            $tierKeys = UserTierKey::join('tier_key_requirements', 'user_tier_keys.id', '=', 'tier_key_requirements.user_tier_key_id')
                ->where('tier_key_requirements.tier_id', $tierId)
                ->where('user_tier_keys.is_active', true)
                ->select('user_tier_keys.*', 'tier_key_requirements.is_required')
                ->get();

            $meetsCriteria = true;

            // Filter the keys based on conditions and requirements
            $filteredKeys = $tierKeys->filter(function ($key) use ($tierKeys, $user) {
                // If the key has a parent, check the parent's value
                if ($key->parent_key_id) {
                    $parentKeyValue = $user->tierValues()->where('user_tier_key_id', $key->parent_key_id)->value('value');
                    // If the parent's condition is not satisfied, this child key is irrelevant
                    if ($parentKeyValue != $key->condition_value) {
                        return false; // Skip this child key
                    }
                }
                return true; // Include the key if it's a standalone or its parent's condition is satisfied
            });

            foreach ($filteredKeys as $key) {
                $userValue = $user->tierValues()->where('user_tier_key_id', $key->id)->first();

                // Check if the key is required and has a value
                if ($key->is_required && (!$userValue || !$userValue->value)) {
                    // If the key is a child, check if its parent's condition is not satisfied
                    if ($key->parent_key_id) {
                        $parentKeyValue = $user->tierValues()->where('user_tier_key_id', $key->parent_key_id)->value('value');
                        // If the parent's condition is not met (e.g., not checked), ignore this check
                        if ($parentKeyValue != $key->condition_value) {
                            continue; // Skip this required child check
                        }
                    }

                    // If it's a required field that failed the check, mark criteria as not met
                    $meetsCriteria = false;
                    break;
                }
            }

            if ($meetsCriteria) {
                $user->tiers()->syncWithoutDetaching([
                    $tierId => ['status' => true]
                ]);

                $awardedTiers[] = $tierId;

                // Emit the UserUpgradedTier event
                UserUpgradedTier::dispatch($user, $tierId);
            }
        }

        if (empty($awardedTiers)) {
            broadcast(new UserTierEvaluationFailed($user));
            return response()->json(['message' => 'User does not meet the requirements for any of the specified tiers.'], 201);
        }

        return response()->json(['message' => 'Tier(s) awarded successfully.', 'awarded_tiers' => $awardedTiers]);
    }
}
