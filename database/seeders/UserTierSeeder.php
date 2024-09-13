<?php

namespace Database\Seeders;

use App\Models\UserTier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        UserTier::factory(10)->create();
    }    
}
