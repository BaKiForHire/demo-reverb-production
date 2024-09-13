<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\PayoutRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PayoutRequest>
 */
class PayoutRequestFactory extends Factory
{
    protected $model = PayoutRequest::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'seller_id' => User::factory(),
            'auction_id' => Auction::factory(),
            'amount' => $this->faker->randomFloat(2, 100, 5000),
            'status' => 'pending'
        ];
    }
}
