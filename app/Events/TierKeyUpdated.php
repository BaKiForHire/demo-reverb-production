<?php

namespace App\Events;

use App\Models\UserTierKey;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when an admin updates the required fields for a tier.
 */
class TierKeyUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $userTierKey;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\UserTierKey  $userTierKey
     * @return void
     */
    public function __construct(UserTierKey $userTierKey)
    {
        $this->userTierKey = $userTierKey;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [new Channel('tiers.' . $this->userTierKey->tier_id)];
    }
}
