<?php

namespace App\Policies;

use App\Models\User;
use App\Models\AuctionCategory;

class AuctionCategoryPolicy
{
    /**
     * Determine if the user can view the list of categories.
     */
    public function viewAny(User $user)
    {
        return true; // All users can view categories
    }

    /**
     * Determine if the user can view a specific category.
     */
    public function view(User $user, AuctionCategory $auctionCategory)
    {
        return true; // All users can view a category
    }

    /**
     * Determine if the user can create a new category.
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can update a specific category.
     */
    public function update(User $user, AuctionCategory $auctionCategory)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can delete a specific category.
     */
    public function delete(User $user, AuctionCategory $auctionCategory)
    {
        return $user->is_admin;
    }
}
