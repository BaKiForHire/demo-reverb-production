<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PaymentProcessed implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;
    public $status;

    public function __construct(Auction $auction, $status)
    {
        $this->auction = $auction;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('auctions.' . $this->auction->id);
    }

    public function broadcastWith()
    {
        return [
            'auction_id' => $this->auction->id,
            'status' => $this->status,  // 'success' or 'failure'
        ];
    }

    public function broadcastAs()
    {
        return 'auction.payment_processed';
    }
}
