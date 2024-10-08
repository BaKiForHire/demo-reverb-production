<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTierKeyValue extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'user_tier_key_id', 'value'];

    /**
     * Define the relationship with the User.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define the relationship with the UserTierKey.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userTierKey()
    {
        return $this->belongsTo(UserTierKey::class, 'user_tier_key_id');
    }
}
