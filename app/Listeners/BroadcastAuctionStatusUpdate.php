<?php

namespace App\Listeners;

use App\Events\AuctionStatusUpdated;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Support\Facades\Broadcast;

/**
 * Listener for broadcasting auction status updates (e.g., active, frozen, concluded).
 */
class BroadcastAuctionStatusUpdate
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AuctionStatusUpdated  $event
     * @return void
     */
    public function handle(AuctionStatusUpdated $event)
    {
        Broadcast::channel('auction.' . $event->auction->id, function () use ($event) {
            return $event->auction;
        });
    }
}
