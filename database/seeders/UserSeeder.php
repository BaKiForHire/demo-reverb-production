<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Create a single admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@bigborebids.com',
            'password' => bcrypt('password'),
            'is_admin' => true,
        ]);

        // Create 10 random users
        User::factory(10)->create();
    }
}
