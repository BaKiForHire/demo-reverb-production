<?php

namespace App\Listeners;

use App\Events\AuctionCategoryUpdated;
use Illuminate\Support\Facades\Log;

/**
 * Listener for updating auctions when an auction category is updated.
 */
class UpdateAuctionCategories
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\AuctionCategoryUpdated  $event
     * @return void
     */
    public function handle(AuctionCategoryUpdated $event)
    {
        Log::info("Category '{$event->category->name}' was updated with action: {$event->action}");

        // Handle the logic to update related auctions (if necessary)
    }
}
