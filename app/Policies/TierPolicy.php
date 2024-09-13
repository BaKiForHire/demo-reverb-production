<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Tier;

class TierPolicy
{
    /**
     * Determine if the user can view the list of tiers.
     */
    public function viewAny(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can view a specific tier.
     */
    public function view(User $user, Tier $tier)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can create a new tier.
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can update a specific tier.
     */
    public function update(User $user, Tier $tier)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can delete a specific tier.
     */
    public function delete(User $user, Tier $tier)
    {
        return $user->is_admin;
    }
}
