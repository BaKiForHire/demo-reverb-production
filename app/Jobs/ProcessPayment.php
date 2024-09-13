<?php

namespace App\Jobs;

use App\Events\PaymentProcessed;
use App\Models\Auction;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentSuccess;
use App\Mail\PaymentFailure;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessPayment implements ShouldQueue
{
    protected $auction;
    protected $winner;

    public function __construct(Auction $auction, User $winner)
    {
        $this->auction = $auction;
        $this->winner = $winner;
    }

    public function handle()
    {
        // Simulate payment processing...
        $paymentSuccessful = $this->attemptPayment();

        if ($paymentSuccessful) {
            // Notify success via email and WebSocket
            Mail::to($this->winner->email)->send(new PaymentSuccess($this->auction));
            event(new PaymentProcessed($this->auction, 'success'));
        } else {
            // Notify failure via email and WebSocket
            Mail::to($this->winner->email)->send(new PaymentFailure($this->auction));
            event(new PaymentProcessed($this->auction, 'failure'));
        }
    }

    protected function attemptPayment()
    {
        // Simulate a payment attempt (logic to integrate payment gateway here)
        return rand(0, 1) == 1; // Random success/failure for testing
    }
}
