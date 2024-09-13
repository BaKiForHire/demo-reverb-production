<?php

namespace Database\Factories;

use App\Models\Tier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tier>
 */
class TierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Tier::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word, // This should not be null
            'description' => $this->faker->sentence,
        ];
    }
}
