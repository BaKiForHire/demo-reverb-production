<?php

namespace App\Console\Commands;

use App\Events\BidPlaced;
use App\Models\Auction;
use App\Models\Bid;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;

class PlaceBidCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auction:place-bid {auction_id} {amount} {user_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Place a bid on an auction through the command line';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $auctionId = $this->argument('auction_id');
        $amount = $this->argument('amount');
        $userId = $this->argument('user_id');

        // Authenticate the user
        $user = User::find($userId);
        if (!$user) {
            $this->error('User not found.');
            return;
        }

        Auth::login($user); // Simulate user login

        // Find the auction
        $auction = Auction::find($auctionId);
        if (!$auction) {
            $this->error('Auction not found.');
            return;
        }

        // Ensure the auction is active
        if ($auction->status !== 'active') {
            $this->error('The auction is not active.');
            return;
        }

        // Ensure the bid is higher than the current price
        if ($amount <= $auction->current_price) {
            $this->error('Bid amount must be higher than the current price.');
            return;
        }

        // Create the bid
        $bid = Bid::create([
            'auction_id' => $auction->id,
            'user_id' => $user->id,
            'amount' => $amount,
        ]);

        // Update auction's current price
        $auction->current_price = $amount;

        // If the auction has less than 2 minutes remaining, extend the grace period
        $auction->extendGracePeriod();

        $auction->save();

        // Emit the bid placed event with a real Bid model instance
        event(new BidPlaced($bid));


        $this->info('Bid placed successfully!');
        $this->info("Auction new price: {$auction->current_price}");
        $this->info("Auction new end time: {$auction->end_time}");
        $this->info("Grace extension count: {$auction->grace_extension_count}");
        $this->info("Bid: {$bid->amount}");
    }
}
