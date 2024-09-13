<?php

namespace Database\Seeders;

use App\Models\UserTierKey;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserTierKeySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        UserTierKey::factory(10)->create();
    }
}
