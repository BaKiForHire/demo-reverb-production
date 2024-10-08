<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
    /**
     * Class FavoriteAuction
     *
     * This model represents a user's favorite auction.
     *
     * @property int $user_id The ID of the user who favorited the auction.
     * @property int $auction_id The ID of the auction that was favorited.
     * @property \Illuminate\Support\Carbon $first_favorited The timestamp when the auction was first favorited.
     * @property \Illuminate\Support\Carbon $last_unfavorited The timestamp when the auction was last unfavorited.
     *
     * @property-read \App\Models\User $user The user who favorited the auction.
     * @property-read \App\Models\Auction $auction The auction that was favorited.
     *
     * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAuction newModelQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAuction newQuery()
     * @method static \Illuminate\Database\Eloquent\Builder|FavoriteAuction query()
     */
class FavoriteAuction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'auction_id',
        'first_favorited',
        'last_unfavorited'
    ];

    protected $dates = ['first_favorited', 'last_unfavorited'];

    /**
     * Get the user that owns the favorite auction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the auction that is marked as favorite.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function auction()
    {
        return $this->belongsTo(Auction::class);
    }
}
