<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AuctionGracePeriodExtended implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function broadcastOn()
    {
        return new Channel('auctions.' . $this->auction->id);
    }

    public function broadcastWith()
    {
        return [
            'auction_id' => $this->auction->id,
            'new_end_time' => $this->auction->end_time,
            'grace_count' => $this->auction->grace_count,
        ];
    }

    public function broadcastAs()
    {
        return 'auction.grace_period_extended';
    }
}
