<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Auction;
use App\Models\UserTierKey;
use Illuminate\Http\Request;

/**
 * Controller for admin-specific actions.
 * Handles user and auction management.
 */
class AdminController extends Controller
{
    /**
     * Display a listing of all users for management purposes.
     * Admin only.
     */
    public function manageUsers()
    {
        $this->authorize('viewAny', User::class);

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Display a listing of all auctions for management purposes.
     * Admin only.
     */
    public function manageAuctions()
    {
        $this->authorize('viewAny', Auction::class);

        $auctions = Auction::all();
        return response()->json($auctions);
    }

    /**
     * Update required fields for a specific tier.
     * Admin only.
     */
    public function updateTierRequirements(Request $request)
    {
        $this->authorize('update', UserTierKey::class);

        // Validate the request data
        $request->validate([
            'tier_id' => 'required|integer|exists:tiers,id',
            'keys' => 'required|array',
            'keys.*.id' => 'required|integer|exists:user_tier_keys,id',
            'keys.*.required' => 'required|boolean',
        ]);

        foreach ($request->keys as $keyData) {
            $tierKey = UserTierKey::find($keyData['id']);
            if ($tierKey) {
                $tierKey->required = $keyData['required'];
                $tierKey->save();
            }
        }

        return response()->json(['message' => 'Tier requirements updated successfully.']);
    }
}
