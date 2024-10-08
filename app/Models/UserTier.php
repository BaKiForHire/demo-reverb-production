<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserTier
 *
 * This class represents the UserTier model in the application.
 * It is used to interact with the 'user_tiers' table in the database.
 * 
 * 
 * The status key is a boolean indicating the active status of the tier.
 * - true: The tier is active.
 * - false: The tier is inactive.
 *
 * @package App\Models
 */
class UserTier extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tier_id', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}
