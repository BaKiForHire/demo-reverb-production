<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Payment
 *
 * This model represents the payment record for auctions, storing details about the buyer's
 * payment for a winning bid.
 *
 * @package App\Models
 */
class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id', 'user_id', 'amount', 'status', 'payment_method'
    ];

    /**
     * Payment belongs to an Auction.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Payment belongs to a User (buyer).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
