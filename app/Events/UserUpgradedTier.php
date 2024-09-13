<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when a user upgrades their tier.
 */
class UserUpgradedTier
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;
    public $tierId;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\User  $user
     * @param  int  $tierId
     * @return void
     */
    public function __construct(User $user, $tierId)
    {
        $this->user = $user;
        $this->tierId = $tierId;
    }
}
