<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AuctionUpdateMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $auction;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($auction)
    {
        $this->auction = $auction;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Auction Update')
                    ->markdown('emails.auction-update');
    }
}
