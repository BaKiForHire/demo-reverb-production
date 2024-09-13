<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bid extends Model
{
    use HasFactory;

    protected $fillable = ['auction_id', 'user_id', 'amount', 'is_winning_bid'];

    protected $hidden = [ 'id', 'auction'];

    /**
     * Get the auction associated with the Bid
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }

    /**
     * Get the user associated with the Bid
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
