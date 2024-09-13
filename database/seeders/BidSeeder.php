<?php

namespace Database\Seeders;

use App\Models\Bid;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Bid::factory(50)->create();
    }
}
