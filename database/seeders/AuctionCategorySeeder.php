<?php

namespace Database\Seeders;

use App\Models\AuctionCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuctionCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        AuctionCategory::factory(5)->create();
    }    
}
