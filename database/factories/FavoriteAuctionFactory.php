<?php

namespace Database\Factories;

use App\Models\Auction;
use App\Models\FavoriteAuction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FavoriteAuction>
 */
class FavoriteAuctionFactory extends Factory
{
    protected $model = FavoriteAuction::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory(), // Random user
            'auction_id' => Auction::factory(), // Random auction
            'first_favorited' => $this->faker->dateTimeThisYear(),
            'last_unfavorited' => null,
        ];
    }
}
