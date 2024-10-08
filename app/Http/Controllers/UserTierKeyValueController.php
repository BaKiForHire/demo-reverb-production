<?php

namespace App\Http\Controllers;

use App\Models\UserTierKey;
use App\Models\UserTierKeyValue;
use Illuminate\Http\Request;

class UserTierKeyValueController extends Controller
{
    /**
     * Store or update the user key value.
     */
    public function storeOrUpdate(Request $request)
    {
        $userId = $request->user()->id;

        // Retrieve the key to check for dropdown validation and parent conditions
        $userTierKey = UserTierKey::find($request->user_tier_key_id);

        // Check if this key has a parent
        if ($userTierKey->parent_key_id) {
            // Retrieve the parent's value
            $parentKeyValue = UserTierKeyValue::where('user_id', $userId)
                ->where('user_tier_key_id', $userTierKey->parent_key_id)
                ->value('value');

            // If the parent key is a boolean and is set to 'false', skip validation and pretend the field was processed
            $parentKey = UserTierKey::find($userTierKey->parent_key_id);
            if ($parentKey && $parentKey->data_type === 'boolean' && $parentKeyValue === 'false') {
                return response()->json(['message' => 'Parent key is false; skipping processing.'], 200);
            }
        }

        // If no parent condition is blocking, proceed with validation
        $request->validate([
            'user_tier_key_id' => 'required|exists:user_tier_keys,id',
            'value' => 'required',
        ]);

        // Validate dropdown values if applicable
        if ($userTierKey->data_type === 'dropdown' && $userTierKey->dropdown_values) {
            $dropdownOptions = json_decode($userTierKey->dropdown_values, true);
            if (!in_array($request->value, $dropdownOptions)) {
                return response()->json(['message' => 'Invalid dropdown value.'], 400);
            }
        }

        // Update or create the user tier key value
        $userTierKeyValue = UserTierKeyValue::updateOrCreate(
            ['user_id' => $userId, 'user_tier_key_id' => $request->user_tier_key_id],
            ['value' => $request->value]
        );

        return response()->json(['message' => 'Value saved successfully.', 'data' => $userTierKeyValue]);
    }
}
