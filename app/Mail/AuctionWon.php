<?php

namespace App\Mail;

use App\Models\Auction;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionWon extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;
    public $winner;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Auction $auction
     * @param \App\Models\User $winner
     * @return void
     */
    public function __construct(Auction $auction, User $winner)
    {
        $this->auction = $auction;
        $this->winner = $winner;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('You Won the Auction!')
                    ->view('emails.auction_won')
                    ->with([
                        'auctionTitle' => $this->auction->title,
                        'amount' => $this->auction->current_price,
                        'winnerName' => $this->winner->name,
                    ]);
    }
}
