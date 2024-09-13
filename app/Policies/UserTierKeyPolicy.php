<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserTierKey;

class UserTierKeyPolicy
{
    /**
     * Determine if the user can view the list of user tier keys.
     */
    public function viewAny(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can create a new user tier key.
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can update a specific user tier key.
     */
    public function update(User $user, UserTierKey $userTierKey)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the user can disable a specific user tier key.
     */
    public function disable(User $user, UserTierKey $userTierKey)
    {
        return $user->is_admin;
    }
}
