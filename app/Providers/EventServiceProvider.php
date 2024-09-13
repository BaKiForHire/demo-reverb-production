<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\{
    UserBidsOnAuction,
    NewAuctionCreated,
    AuctionConcluded,
    UserRegistered,
    UserUpgradedTier,
    TierKeyUpdated,
    AdminActionOnAuction,
    AuctionCategoryUpdated,
    AuctionStatusUpdated,
    BidPlaced,
    NotificationSent
};
use App\Listeners\{
    NotifyUsersOfNewBid,
    NotifyUsersOfNewAuction,
    SendAuctionConcludedNotifications,
    SendUserRegisteredWelcomeEmail,
    NotifyUserOfTierUpgrade,
    NotifyUsersOfTierKeyUpdate,
    LogAdminActionOnAuction,
    UpdateAuctionCategories,
    BroadcastAuctionStatusUpdate,
    HandleNotificationSending
};

/**
 * EventServiceProvider registers all the application's events and listeners.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NewAuctionCreated::class => [
            NotifyUsersOfNewAuction::class,
        ],
        AuctionConcluded::class => [
            SendAuctionConcludedNotifications::class,
        ],
        UserRegistered::class => [
            SendUserRegisteredWelcomeEmail::class,
        ],
        UserUpgradedTier::class => [
            NotifyUserOfTierUpgrade::class,
        ],
        TierKeyUpdated::class => [
            NotifyUsersOfTierKeyUpdate::class,
        ],
        AdminActionOnAuction::class => [
            LogAdminActionOnAuction::class,
        ],
        AuctionCategoryUpdated::class => [
            UpdateAuctionCategories::class,
        ],
        BidPlaced::class => [
            NotifyUsersOfNewBid::class,
        ],
        AuctionStatusUpdated::class => [
            BroadcastAuctionStatusUpdate::class,
        ],
        NotificationSent::class => [
            HandleNotificationSending::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // Custom event registration if needed
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
