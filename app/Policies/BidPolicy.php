<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Bid;

class BidPolicy
{
    /**
     * Determine if the user can place a bid on an auction.
     */
    public function create(User $user)
    {
        return $user->tiers()->where('name', 'Buyer User')->exists();
    }

    /**
     * Determine if the user can view the bids for an auction.
     */
    public function viewAny(User $user)
    {
        return $user->is_admin || $user->tiers()->where('name', 'Buyer User')->exists();
    }

    /**
     * Determine if the user can view a specific bid.
     */
    public function view(User $user, Bid $bid)
    {
        return $user->id === $bid->user_id || $user->is_admin;
    }
}
