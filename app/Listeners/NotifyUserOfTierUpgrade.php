<?php

namespace App\Listeners;

use App\Events\UserUpgradedTier;
use App\Notifications\TierUpgradeNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Listener for notifying a user when their tier is upgraded.
 */
class NotifyUserOfTierUpgrade
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\UserUpgradedTier  $event
     * @return void
     */
    public function handle(UserUpgradedTier $event)
    {
        Notification::send($event->user, new TierUpgradeNotification($event->tierId));
    }
}
