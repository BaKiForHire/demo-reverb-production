<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PayoutRequest
 *
 * This model represents a seller's request for a payout after an auction concludes,
 * requiring the seller to upload shipping proof before the request is processed.
 *
 * @package App\Models
 */
class PayoutRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id', 'auction_id', 'amount', 'status'
    ];

    /**
     * PayoutRequest belongs to an Auction.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * PayoutRequest belongs to a User (seller).
     */
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
