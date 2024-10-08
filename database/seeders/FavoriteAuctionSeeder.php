<?php

namespace Database\Seeders;

use App\Models\FavoriteAuction;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FavoriteAuctionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FavoriteAuction::factory()->count(50)->create();
    }
}
