<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

    protected $fillable = ['auction_id', 'media_type', 'url', 'alt_text'];

    /**
     * Get the auction that owns the media.
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
