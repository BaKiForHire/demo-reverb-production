<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\ShippingOption;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingOption>
 */
class ShippingOptionFactory extends Factory
{
    protected $model = ShippingOption::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'auction_id' => Auction::factory(),
            'type' => $this->faker->randomElement(['Standard', 'Express']),
            'cost' => $this->faker->randomFloat(2, 5, 100),
            'details' => $this->faker->sentence
        ];
    }
}
