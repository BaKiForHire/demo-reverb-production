<?php

namespace App\Listeners;

use App\Events\BidPlaced;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewBidNotification;

/**
 * Listener for notifying users of a new bid on an auction.
 */
class NotifyUsersOfNewBid
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\BidPlaced  $event
     * @return void
     */
    public function handle(BidPlaced $event)
    {
        $auction = $event->bid->auction;

        // Notify users watching the auction (this could be customized)
        Notification::send($auction->watchers, new NewBidNotification($event->bid));
    }
}
