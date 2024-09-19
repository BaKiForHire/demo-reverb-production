<?php

namespace App\Models;

use App\Events\AuctionGracePeriodExtended;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Auction extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'start_price',
        'current_price',
        'start_time',
        'end_time',
        'user_id',
        'status',
        'thumbnail_url',
        'location_id',
        'winning_bid_id',
        'payment_status',
        'payout_status',
        'has_shipping_proof',
        'shipping_proof_url',
        'grace_extension_count'
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    /**
     * Get the user associated with the Auction
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the bids associated with the Auction
     */
    public function bids()
    {
        return $this->hasMany(Bid::class);
    }

    /**
     * Get the winning bid associated with the Auction
     */
    public function winningBid()
    {
        return $this->belongsTo(Bid::class, 'winning_bid_id');
    }

    /**
     * Get the comments associated with the Auction
     */
    public function hasShippingProof()
    {
        return $this->has_shipping_proof;
    }

    /**
     * Get the categories associated with the Auction
     */
    public function categories()
    {
        return $this->belongsToMany(AuctionCategory::class, 'auction_category_auction');
    }

    /**
     * Get the location associated with the Auction
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Get the media associated with the Auction
     */
    public function media()
    {
        return $this->hasMany(Media::class);
    }

    /**
     * Get the payments associated with the Auction
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Get the shipping options associated with the Auction
     */
    public function shippingOptions()
    {
        return $this->hasMany(ShippingOption::class);
    }

    /**
     * Extend the grace period of the auction if necessary.
     */
    public function extendGracePeriod()
    {
        // Get the current time
        $now = Carbon::now();
        
        // Calculate the time remaining in seconds
        $timeRemaining = $this->end_time->diffInSeconds($now, false);

        // If the time remaining is less than 120 seconds and greater than 0 (auction is still running)
        if ($timeRemaining > 0 && $timeRemaining < 120) {
            // Calculate how many seconds need to be added to make the remaining time 120 seconds
            $secondsToAdd = 120 - $timeRemaining;

            // Add the required seconds to the auction's end time
            $this->end_time = $this->end_time->addSeconds($secondsToAdd);
            
            // Increment the grace period extension count
            $this->grace_extension_count += 1;
            
            // Save the changes
            $this->save();

            // Emit an event to notify clients of the grace period extension
            event(new AuctionGracePeriodExtended($this));
        }
    }
}
