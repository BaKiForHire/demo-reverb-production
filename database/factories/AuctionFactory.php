<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Location;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Auction>
 */
class AuctionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Auction::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'start_price' => $this->faker->randomFloat(2, 10, 1000),
            'current_price' => $this->faker->randomFloat(2, 10, 1000),
            'start_time' => $this->faker->dateTimeBetween('-1 week', '+1 week'),
            'end_time' => $this->faker->dateTimeBetween('+1 week', '+1 month'),
            'user_id' => User::factory(),
            'location_id' => Location::factory(),
            'status' => 'active',
            'thumbnail_url' => $this->faker->imageUrl(),
            'hash' => $this->faker->unique()->regexify('[A-Za-z0-9]{10}'),
        ];
    }
}
