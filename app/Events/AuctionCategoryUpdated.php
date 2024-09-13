<?php

namespace App\Events;

use App\Models\AuctionCategory;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

/**
 * Event triggered when an auction category is updated or deleted.
 */
class AuctionCategoryUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    public $action;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\AuctionCategory  $category
     * @param  string  $action
     * @return void
     */
    public function __construct(AuctionCategory $category, $action)
    {
        $this->category = $category;
        $this->action = $action;
    }
}
