<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

// Import your models and policies here
use App\Models\User;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\Tier;
use App\Models\UserTierKey;
use App\Models\Notification;
use App\Models\AuctionCategory;
use App\Policies\UserPolicy;
use App\Policies\AuctionPolicy;
use App\Policies\BidPolicy;
use App\Policies\TierPolicy;
use App\Policies\UserTierKeyPolicy;
use App\Policies\NotificationPolicy;
use App\Policies\AuctionCategoryPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        Auction::class => AuctionPolicy::class,
        Bid::class => BidPolicy::class,
        Tier::class => TierPolicy::class,
        UserTierKey::class => UserTierKeyPolicy::class,
        Notification::class => NotificationPolicy::class,
        AuctionCategory::class => AuctionCategoryPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Additional gates can be defined here if needed
    }
}
