<?php

namespace Database\Seeders;

use App\Models\PayoutRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PayoutRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PayoutRequest::factory(5)->create();
    }
}
