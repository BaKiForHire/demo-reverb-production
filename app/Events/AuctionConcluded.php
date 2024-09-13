<?php

namespace App\Events;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when an auction concludes.
 */
class AuctionConcluded
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;
    public $winner;

    /**
     * Create a new event instance.
     *
     * @param Auction $auction
     * @param User $winner
     */
    public function __construct(Auction $auction, User $winner)
    {
        $this->auction = $auction;
        $this->winner = $winner;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return PrivateChannel
     */
    public function broadcastOn()
    {
        return new PrivateChannel('auctions.' . $this->auction->id);
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'auction_id' => $this->auction->id,
            'winner_id' => $this->winner->id,
            'status' => 'concluded',
        ];
    }

    /**
     * Get the event name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'auction.concluded';
    }
}
