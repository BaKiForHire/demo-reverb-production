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
    public function index($tierId)
    {
        $tierKeys = UserTierKey::where('tier_id', $tierId)->get();
        return response()->json($tierKeys);
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
            'name', 'identifier', 'tier_id', 'is_active', 'data_type', 'validation_rules', 'required',
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
            'name', 'identifier', 'is_active', 'data_type', 'validation_rules', 'required',
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
