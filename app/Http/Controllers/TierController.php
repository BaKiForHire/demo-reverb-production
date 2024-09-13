<?php

namespace App\Http\Controllers;

use App\Models\Tier;
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
}
