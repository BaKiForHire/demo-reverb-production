<?php

namespace Database\Factories;

use App\Models\Tier;
use App\Models\UserTierKey;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTierKey>
 */
class UserTierKeyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserTierKey::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'identifier' => $this->faker->unique()->word,
            'tier_id' => Tier::factory(),
            'is_active' => $this->faker->boolean,
            'data_type' => $this->faker->randomElement(['string', 'number', 'date', 'dropdown']),
            'validation_rules' => json_encode(['required', 'string', 'max:255']),
        ];
    }
}
