<?php

namespace App\Models;

use App\Events\AuctionGracePeriodExtended;
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
        'shipping_proof_url'
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
     * Extend the grace period of the auction by 2 minutes
     */
    public function extendGracePeriod()
    {
        // Check if the bid is placed within the last 2 minutes of the auction
        if (now()->diffInMinutes($this->end_time, false) <= 2) {
            $this->end_time = $this->end_time->addMinutes(2);
            $this->grace_count += 1;
            $this->save();

            // Emit a WebSocket event to notify all connected clients
            event(new AuctionGracePeriodExtended($this));
        }
    }
}
