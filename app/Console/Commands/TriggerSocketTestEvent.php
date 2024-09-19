<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\BidPlaced;
use App\Models\Bid;
use App\Models\Auction;
use App\Models\User;
use Faker\Factory as Faker;

class TriggerSocketTestEvent extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'trigger:bid-event';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Trigger a BidPlaced event with random bid data';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        // Create a fake instance using Faker or manually set data
        $faker = Faker::create();

        // Assuming you have auctions and users in your database, 
        // you can fetch random ones for this test. Otherwise, you can use dummy data.
        $auction = Auction::find(1) ?? Auction::factory()->create();
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        // Create a random bid
        $bid = new Bid([
            'auction_id' => $auction->id,
            'user_id' => $user->id,
            'amount' => $faker->randomFloat(2, 10, 1000), // Random amount between 10 and 1000
        ]);

        // Save the bid to the database
        $bid->save();

        // Dispatch the event with the newly created bid
        event(new BidPlaced($bid));

        // Output confirmation message
        $this->info('BidPlaced event dispatched with random bid data.');

        return 0;
    }
}
