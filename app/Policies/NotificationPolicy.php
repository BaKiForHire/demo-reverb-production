<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Notification;

class NotificationPolicy
{
    /**
     * Determine if the user can view the notifications.
     */
    public function viewAny(User $user)
    {
        return true; // Every authenticated user can view their own notifications
    }

    /**
     * Determine if the user can mark a notification as read.
     */
    public function markAsRead(User $user, Notification $notification)
    {
        return $user->id === $notification->user_id;
    }
}
