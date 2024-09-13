<?php

namespace App\Events;

use App\Models\Notification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when a notification is sent to a user.
 */
class NotificationSent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $notification;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\Notification  $notification
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
    }
}
