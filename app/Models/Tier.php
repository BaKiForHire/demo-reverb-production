<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tier extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_tiers')->withPivot('status');
    }

    public function userTierKeys()
    {
        return $this->hasMany(UserTierKey::class);
    }
}
