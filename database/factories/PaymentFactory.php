<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    protected $model = Payment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'auction_id' => Auction::factory(),
            'user_id' => User::factory(),
            'amount' => $this->faker->randomFloat(2, 50, 5000),
            'status' => 'pending',
            'payment_method' => $this->faker->creditCardType
        ];
    }
}
