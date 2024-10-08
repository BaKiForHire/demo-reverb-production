<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    protected $appends = ['status'];

    protected $hidden = ['pivot'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tiers')->withPivot('status');
    }

    public function userTierKeys()
    {
        return $this->hasMany(UserTierKey::class);
    }

    // Relationship with UserTierKeys through the tier_key_requirements pivot table
    public function requiredKeys()
    {
        return $this->belongsToMany(UserTierKey::class, 'tier_key_requirements')
                    ->withPivot('is_required');
    }

    public function getStatusAttribute()
    {
        // Check if the pivot exists and has a 'status' key
        return $this->pivot ? $this->pivot->status : null;
    }
}
