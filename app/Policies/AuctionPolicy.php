<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Auction;

class AuctionPolicy
{
    /**
     * Determine if the given auction can be viewed by the user.
     */
    public function view(User $user, Auction $auction)
    {
        // Allow viewing if the auction is active or the user is an admin
        return $auction->status === 'active' || $user->is_admin;
    }

    /**
     * Determine if the user can create auctions.
     */
    public function create(User $user)
    {
        // Only users with a specific tier can create auctions
        return $user->tiers()->where('name', 'Seller User')->exists();
    }

    /**
     * Determine if the user can update the auction.
     */
    public function update(User $user, Auction $auction)
    {
        // Allow updates if the user is the owner or an admin
        return $user->id === $auction->user_id || $user->is_admin;
    }

    /**
     * Determine if the user can delete the auction.
     */
    public function delete(User $user, Auction $auction)
    {
        // Allow deletion if the user is the owner or an admin
        return $user->id === $auction->user_id || $user->is_admin;
    }

    /**
     * Determine if the user can freeze the auction.
     */
    public function freeze(User $user, Auction $auction)
    {
        // Only admins can freeze auctions
        return $user->is_admin;
    }
}
