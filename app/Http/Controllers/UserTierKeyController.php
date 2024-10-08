<?php

namespace App\Http\Controllers;

use App\Models\UserTierKey;
use Illuminate\Http\Request;

/**
 * Controller for managing user tier keys.
 * Handles listing, creating, updating, and disabling tier keys.
 */
class UserTierKeyController extends Controller
{
    /**
     * Display all keys for a specific tier.
     */
    public function index(Request $request, $tierId)
    {
        $userId = $request->user()->id;

        // Fetch all keys for the specified tier from the pivot table
        $tierKeys = UserTierKey::join('tier_key_requirements', 'user_tier_keys.id', '=', 'tier_key_requirements.user_tier_key_id')
            ->where('tier_key_requirements.tier_id', $tierId)
            ->where('user_tier_keys.is_active', true)
            ->leftJoin('user_tier_key_values', function ($join) use ($userId) {
                $join->on('user_tier_keys.id', '=', 'user_tier_key_values.user_tier_key_id')
                    ->where('user_tier_key_values.user_id', '=', $userId);
            })
            ->select(
                'user_tier_keys.*',
                'user_tier_key_values.value',
                'tier_key_requirements.is_required',
                'user_tier_keys.dropdown_values'
            )
            ->get();

        // Create an associative array to handle keys by their ID for easier lookups
        $keyById = $tierKeys->keyBy('id');

        // Fetch all conditional keys that depend on the current keys
        $conditionalKeys = UserTierKey::whereIn('parent_key_id', $tierKeys->pluck('id')->toArray())
            ->leftJoin('user_tier_key_values', function ($join) use ($userId) {
                $join->on('user_tier_keys.id', '=', 'user_tier_key_values.user_tier_key_id')
                    ->where('user_tier_key_values.user_id', '=', $userId);
            })
            ->select(
                'user_tier_keys.*',
                'user_tier_key_values.value',
                'user_tier_keys.dropdown_values'
            )
            ->get();

        // Merge conditional keys into the original keys collection
        $allKeys = $tierKeys->merge($conditionalKeys);

        // Invalidate parent keys if child keys do not have values
        $keysToInvalidate = [];
        foreach ($allKeys as $key) {
            if ($key->parent_key_id && empty($key->value)) {
                $keysToInvalidate[] = $key->parent_key_id;
            }
        }

        // Modify the keys collection to set parent values to null if they are invalidated
        $allKeys = $allKeys->map(function ($key) use ($keysToInvalidate) {
            if (in_array($key->id, $keysToInvalidate)) {
                $key->value = null; // Set the value of the parent key to null
            }
            return $key;
        });

        // Filter keys that do not have values or are boolean fields
        $filteredKeys = $allKeys->filter(function ($key) use ($keysToInvalidate) {
            // Return keys that either do not have a value, are parents that need to be invalidated,
            // or are boolean fields (even if set to false)
            return empty($key->value) || in_array($key->id, $keysToInvalidate) || $key->data_type === 'boolean';
        });

        // Flatten the keys while preserving the hierarchy
        $responseKeys = array_values($filteredKeys->toArray());

        return response()->json($responseKeys);
    }


    /**
     * Store a newly created key for a specific tier.
     * Admin only.
     */
    public function store(Request $request)
    {
        $this->authorize('create', UserTierKey::class);

        $request->validate([
            'name' => 'required|string|max:255',
            'identifier' => 'required|string|unique:user_tier_keys,identifier',
            'tier_id' => 'required|exists:tiers,id',
            'is_active' => 'boolean',
            'data_type' => 'required|in:string,number,date,dropdown',
            'validation_rules' => 'nullable|string',
            'required' => 'boolean',
        ]);

        $tierKey = UserTierKey::create($request->only([
            'name',
            'identifier',
            'tier_id',
            'is_active',
            'data_type',
            'validation_rules',
            'required',
        ]));

        return response()->json(['message' => 'Tier key created successfully.', 'tierKey' => $tierKey]);
    }

    /**
     * Update an existing key for a specific tier.
     * Admin only.
     */
    public function update(Request $request, $id)
    {
        $tierKey = UserTierKey::findOrFail($id);
        $this->authorize('update', $tierKey);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'identifier' => 'sometimes|string|unique:user_tier_keys,identifier,' . $id,
            'is_active' => 'boolean',
            'data_type' => 'sometimes|in:string,number,date,dropdown',
            'validation_rules' => 'nullable|string',
            'required' => 'boolean',
        ]);

        $tierKey->update($request->only([
            'name',
            'identifier',
            'is_active',
            'data_type',
            'validation_rules',
            'required',
        ]));

        return response()->json(['message' => 'Tier key updated successfully.', 'tierKey' => $tierKey]);
    }

    /**
     * Disable a key for a specific tier.
     * Admin only.
     */
    public function disable($id)
    {
        $tierKey = UserTierKey::findOrFail($id);
        $this->authorize('update', $tierKey);

        $tierKey->disabled = true;
        $tierKey->save();

        return response()->json(['message' => 'Tier key has been disabled successfully.']);
    }
}
