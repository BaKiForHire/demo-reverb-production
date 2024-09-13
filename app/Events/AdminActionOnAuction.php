<?php

namespace App\Events;

use App\Models\Auction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when an admin takes an action on an auction (e.g., freezing or deleting it).
 */
class AdminActionOnAuction
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $auction;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Auction  $auction
     * @param  string  $action
     * @return void
     */
    public function __construct(Auction $auction, $action)
    {
        $this->auction = $auction;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new Channel('admin.auctions.' . $this->auction->id)];
    }
}
