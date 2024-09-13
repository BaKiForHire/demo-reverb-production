<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the given user can view the list of users.
     */
    public function viewAny(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the given user can view a specific user.
     */
    public function view(User $user, User $model)
    {
        return $user->is_admin || $user->id === $model->id;
    }

    /**
     * Determine if the given user can create a new user.
     * Typically not needed as user registration is open.
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine if the given user can update a specific user.
     */
    public function update(User $user, User $model)
    {
        return $user->is_admin || $user->id === $model->id;
    }

    /**
     * Determine if the given user can delete a specific user.
     */
    public function delete(User $user, User $model)
    {
        return $user->is_admin && $user->id !== $model->id; // Prevent self-deletion for admins
    }
}
