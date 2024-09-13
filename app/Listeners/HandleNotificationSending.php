<?php

namespace App\Listeners;

use App\Events\NotificationSent;

/**
 * Listener for handling the notification sending event.
 */
class HandleNotificationSending
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NotificationSent  $event
     * @return void
     */
    public function handle(NotificationSent $event)
    {
        // Logic for handling the notification
    }
}
