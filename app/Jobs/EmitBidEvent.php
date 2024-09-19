<?php

namespace App\Jobs;

use App\Events\BidPlaced;
use App\Models\Bid;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmitBidEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $bid;

    /**
     * Create a new job instance.
     *
     * @param Bid $bid
     */
    public function __construct(Bid $bid)
    {
        $this->bid = $bid;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Emit the bid placed event
        event(new BidPlaced($this->bid));
    }
}
