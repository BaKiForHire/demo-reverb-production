<?php

namespace App\Listeners;

use App\Events\NewAuctionCreated;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewAuctionNotification;

/**
 * Listener for notifying users when a new auction is created.
 */
class NotifyUsersOfNewAuction
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\NewAuctionCreated  $event
     * @return void
     */
    public function handle(NewAuctionCreated $event)
    {
        // Notify all relevant users about the new auction
        Notification::send(User::all(), new NewAuctionNotification($event->auction));
    }
}
