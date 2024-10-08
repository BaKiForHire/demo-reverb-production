<?php

namespace Database\Seeders;

use App\Models\Tier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create the predefined tiers
        $tiers = [
            ['name' => 'Buyer', 'description' => 'Can bid/buy on items for sale.'],
            ['name' => 'Seller', 'description' => 'Can list items for sale.'],
            ['name' => 'FFL Dealer', 'description' => 'Has additional privileges for bulk uploading and special auctions.'],
        ];

        foreach ($tiers as $tier) {
            Tier::factory()->predefined($tier['name'], $tier['description'])->create();
        }
    }
}
