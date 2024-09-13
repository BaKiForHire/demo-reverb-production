<?php

namespace Database\Seeders;

use App\Models\Auction;
use App\Models\Bid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Auction::factory(10)->create()->each(function ($auction) {
            Bid::factory(5)->create(['auction_id' => $auction->id]);
        });
    }    
}
