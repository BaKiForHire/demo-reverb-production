<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use Database\Seeders\UserSeeder;
use Database\Seeders\TierSeeder;
use Database\Seeders\UserTierSeeder;
use Database\Seeders\UserTierKeySeeder;
use Database\Seeders\AuctionSeeder;
use Database\Seeders\BidSeeder;
use Database\Seeders\CommentSeeder;
use Database\Seeders\AuctionCategorySeeder;
use Database\Seeders\MediaSeeder;
use Database\Seeders\NotificationSeeder;
use Database\Seeders\LocationSeeder;
use Database\Seeders\NewsletterSubscriptionSeeder;
use Database\Seeders\ShippingOptionSeeder;
use Database\Seeders\PaymentSeeder;
use Database\Seeders\PayoutRequestSeeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            UserSeeder::class,
            TierSeeder::class,
            UserTierKeySeeder::class, // Moved to ensure tier keys are set up after tiers are seeded
            AuctionSeeder::class,
            BidSeeder::class,
            CommentSeeder::class,
            AuctionCategorySeeder::class,
            MediaSeeder::class,
            NotificationSeeder::class,
            LocationSeeder::class,
            NewsletterSubscriptionSeeder::class,
            ShippingOptionSeeder::class,
            PaymentSeeder::class,
            PayoutRequestSeeder::class,
            FavoriteAuctionSeeder::class,
        ]);
    }
}
