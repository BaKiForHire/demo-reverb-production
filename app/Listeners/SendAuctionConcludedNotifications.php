<?php

namespace App\Listeners;

use App\Events\AuctionConcluded;
use App\Notifications\AuctionConcludedNotification;
use Illuminate\Support\Facades\Notification;

/**
 * Listener for sending notifications when an auction concludes.
 */
class SendAuctionConcludedNotifications
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AuctionConcluded  $event
     * @return void
     */
    public function handle(AuctionConcluded $event)
    {
        $auction = $event->auction;

        // Notify the auction creator and the winning bidder
        Notification::send([$auction->creator, $auction->winningBidder], new AuctionConcludedNotification($auction));
    }
}
