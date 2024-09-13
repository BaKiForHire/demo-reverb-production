<?php

namespace App\Mail;

use App\Models\Auction;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentSuccess extends Mailable
{
    use Queueable, SerializesModels;

    public $auction;

    /**
     * Create a new message instance.
     *
     * @param \App\Models\Auction $auction
     * @return void
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
        return $this->subject('Payment Successful for Auction')
                    ->view('emails.payment_success')
                    ->with([
                        'auctionTitle' => $this->auction->title,
                        'amount' => $this->auction->current_price,
                    ]);
    }
}
