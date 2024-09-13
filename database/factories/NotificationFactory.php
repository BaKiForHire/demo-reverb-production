<?php

namespace Database\Factories;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = Notification::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement(['auction_update', 'tier_change']),
            'data' => json_encode(['message' => $this->faker->sentence]),
            'read_at' => null,
        ];
    }
}