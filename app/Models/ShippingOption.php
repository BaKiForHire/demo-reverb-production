<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class ShippingOption
 *
 * This model represents the available shipping options for auctions,
 * containing details about the type, cost, and extra information.
 *
 * @package App\Models
 */
class ShippingOption extends Model
{
    use HasFactory;

    protected $fillable = [
        'auction_id', 'type', 'cost', 'details'
    ];

    /**
     * ShippingOption belongs to an Auction.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
