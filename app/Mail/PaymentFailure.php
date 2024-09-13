<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentFailure extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Auction $auction
     */
    public function __construct(Auction $auction)
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
        return $this->subject('Payment Failed for Auction')
                    ->view('emails.payment_failure')
                    ->with([
                        'auctionTitle' => $this->auction->title,
                        'amount' => $this->auction->current_price,
                    ]);
    }
}
