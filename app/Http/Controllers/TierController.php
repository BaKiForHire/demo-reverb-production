<?php

namespace App\Http\Controllers;

use App\Models\Tier;
use App\Models\User;
use App\Models\UserTierKey;
use Illuminate\Http\Request;

/**
 * Controller for managing tiers.
 * Handles listing, showing, creating, and updating tiers.
 */
class TierController extends Controller
{
    /**
     * Display a listing of all available tiers.
     */
    public function index()
    {
        $tiers = Tier::all();
        return response()->json($tiers);
    }

    /**
     * Display the specified tier.
     */
    public function show($id)
    {
        $tier = Tier::with('userTierKeys')->findOrFail($id);
        return response()->json($tier);
    }

    /**
     * Store a newly created tier in storage.
     * Admin only.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Tier::class);

        $request->validate([
            'name' => 'required|string|max:255|unique:tiers,name',
            'description' => 'nullable|string',
        ]);

        $tier = Tier::create($request->only(['name', 'description']));

        return response()->json(['message' => 'Tier created successfully.', 'tier' => $tier]);
    }

    /**
     * Update the specified tier in storage.
     * Admin only.
     */
    public function update(Request $request, $id)
    {
        $tier = Tier::findOrFail($id);
        $this->authorize('update', $tier);

        $request->validate([
            'name' => 'sometimes|string|max:255|unique:tiers,name,' . $id,
            'description' => 'nullable|string',
        ]);

        $tier->update($request->only(['name', 'description']));

        return response()->json(['message' => 'Tier updated successfully.', 'tier' => $tier]);
    }

    public static function getUserTierDetails(User $user)
    {
        $user->load('tiers');
        $currentTiers = $user->tiers;
        $tiersToUpdate = [];
        $tiersWithDetails = [];

        foreach ($currentTiers as $tier) {
            $tierKeys = UserTierKey::join('tier_key_requirements', 'user_tier_keys.id', '=', 'tier_key_requirements.user_tier_key_id')
                ->where('tier_key_requirements.tier_id', $tier->id)
                ->where('user_tier_keys.is_active', true)
                ->select('user_tier_keys.*')
                ->get();

            $meetsCriteria = true;
            $failedChildKeys = [];

            // Filter tier keys
            $filteredKeys = self::filterTierKeys($tierKeys, $user);
            foreach ($filteredKeys as $key) {
                $userValue = $user->tierValues()->where('user_tier_key_id', $key->id)->first();

                if (!$userValue || !$userValue->value) {
                    $meetsCriteria = false;
                    $failedChildKeys[] = $key;
                    break;
                }

                if ($key->data_type === 'boolean' && ($userValue->value === 'true' || $userValue->value === true)) {
                    $childKeys = $tierKeys->filter(fn($childKey) => $childKey->parent_key_id === $key->id);
                    foreach ($childKeys as $childKey) {
                        $childValue = $user->tierValues()->where('user_ttier_key_id', $childKey->id)->first();
                        if (!$childValue || !$childValue->value) {
                            $meetsCriteria = false;
                            $failedChildKeys[] = $childKey;
                            break;
                        }
                    }
                }

                if (!$meetsCriteria) {
                    break;
                }
            }

            if (!$meetsCriteria) {
                $tiersToUpdate[$tier->id] = ['status' => false];
            }

            $tiersWithDetails[] = [
                'tier_id' => $tier->id,
                'meets_criteria' => $meetsCriteria,
                'failed_child_keys' => $failedChildKeys,
            ];
        }

        self::updateTiers($user, $tiersToUpdate);

        // Check for new eligible tiers
        $availableTiers = self::checkForNewTiers($user, $tiersToUpdate);

        return [
            'tiersWithDetails' => $tiersWithDetails,
            'availableTiers' => $availableTiers,
        ];
    }

    private static function filterTierKeys($tierKeys, $user)
    {
        return $tierKeys->filter(function ($key) use ($tierKeys, $user) {
            if ($key->parent_key_id) {
                $parentKeyValue = $user->tierValues()->where('user_tier_key_id', $key->parent_key_id)->value('value');
                return $parentKeyValue == $key->condition_value;
            }
            return true;
        });
    }

    private static function updateTiers(User $user, $tiersToUpdate)
    {
        if (!empty($tiersToUpdate)) {
            $user->tiers()->syncWithoutDetaching($tiersToUpdate);
        }
    }

    private static function checkForNewTiers(User $user, $tiersToUpdate)
    {
        $availableTiers = Tier::all();
        $awardedTiers = [];

        foreach ($availableTiers as $tier) {
            if (!in_array($tier->id, array_keys($tiersToUpdate))) {
                $tierKeys = UserTierKey::join('tier_key_requirements', 'user_tier_keys.id', '=', 'tier_key_requirements.user_tier_key_id')
                    ->where('tier_key_requirements.tier_id', $tier->id)
                    ->where('user_tier_keys.is_active', true)
                    ->select('user_tier_keys.*')
                    ->get();

                $meetsCriteria = true;

                $filteredKeys = self::filterTierKeys($tierKeys, $user);
                foreach ($filteredKeys as $key) {
                    $userValue = $user->tierValues()->where('user_tier_key_id', $key->id)->first();

                    if (!$userValue || !$userValue->value) {
                        $meetsCriteria = false;
                        break;
                    }

                    if ($key->data_type === 'boolean' && ($userValue->value === 'true' || $userValue->value === true)) {
                        $childKeys = $tierKeys->filter(fn($childKey) => $childKey->parent_key_id === $key->id);
                        foreach ($childKeys as $childKey) {
                            $childValue = $user->tierValues()->where('user_tier_key_id', $childKey->id)->first();
                            if (!$childValue || !$childValue->value) {
                                $meetsCriteria = false;
                                break;
                            }
                        }
                    }

                    if (!$meetsCriteria) {
                        break;
                    }
                }

                if ($meetsCriteria) {
                    $awardedTiers[$tier->id] = ['status' => true];
                }
            }
        }

        if (!empty($awardedTiers)) {
            $user->tiers()->syncWithoutDetaching($awardedTiers);
        }

        return $availableTiers;
    }
}
