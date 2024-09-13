<?php

namespace App\Jobs;

use App\Models\Auction;
use App\Events\AuctionConcluded;
use App\Mail\AuctionWon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessAuctionConclusion implements ShouldQueue
{
    use InteractsWithQueue, SerializesModels;

    protected $auction;

    public function __construct(Auction $auction)
    {
        $this->auction = $auction;
    }

    public function handle()
    {
        // Mark auction as concluded
        $this->auction->status = 'concluded';
        $this->auction->save();

        // Notify the highest bidder via email
        $winner = $this->auction->bids()->latest()->first()->user;
        Mail::to($winner->email)->send(new AuctionWon($this->auction, $winner));

        // Emit WebSocket event to notify users of auction conclusion
        event(new AuctionConcluded($this->auction, $winner));

        // Trigger payment processing job here
        dispatch(new ProcessPayment($this->auction, $winner));
    }
}
