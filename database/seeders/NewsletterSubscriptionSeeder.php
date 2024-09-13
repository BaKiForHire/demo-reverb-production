<?php

namespace Database\Seeders;

use App\Models\NewsletterSubscription;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsletterSubscriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        NewsletterSubscription::factory(20)->create();
    }
}
