<?php

namespace Database\Factories;

use App\Models\Auction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Media>
 */
class MediaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'auction_id' => Auction::factory(),
            'media_type' => $this->faker->randomElement(['image', 'video']),
            'url' => $this->faker->imageUrl(),
            'alt_text' => $this->faker->sentence,
        ];
    }
}
