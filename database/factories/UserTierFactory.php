<?php

namespace Database\Factories;

use App\Models\Tier;
use App\Models\User;
use App\Models\UserTier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTier>
 */
class UserTierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = UserTier::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'tier_id' => Tier::factory(),
            'status' => $this->faker->boolean,
        ];
    }
}
