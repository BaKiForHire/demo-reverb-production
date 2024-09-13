<?php

namespace App\Listeners;

use App\Events\TierKeyUpdated;
use App\Models\User;
use App\Notifications\TierKeyUpdateNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Listener for notifying users when an admin updates a tier's required keys.
 */
class NotifyUsersOfTierKeyUpdate
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\TierKeyUpdated  $event
     * @return void
     */
    public function handle(TierKeyUpdated $event)
    {
        // Notify users in the affected tier
        $users = User::where('tier_id', $event->userTierKey->tier_id)->get();
        Notification::send($users, new TierKeyUpdateNotification($event->userTierKey));
    }
}
