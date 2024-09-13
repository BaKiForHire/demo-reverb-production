<?php

namespace App\Listeners;

use App\Events\AdminActionOnAuction;
use Illuminate\Support\Facades\Log;

/**
 * Listener for logging an admin action on an auction (e.g., freezing or deleting it).
 */
class LogAdminActionOnAuction
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AdminActionOnAuction  $event
     * @return void
     */
    public function handle(AdminActionOnAuction $event)
    {
        Log::info("Admin performed action: {$event->action} on auction ID: {$event->auction->id}");
    }
}
