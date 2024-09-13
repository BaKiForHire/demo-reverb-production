<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when the status of an auction is updated (e.g., active, frozen, or concluded).
 */
class AuctionStatusUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Auction  $auction
     * @return void
     */
    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }
}
