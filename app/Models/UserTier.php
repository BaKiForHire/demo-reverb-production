<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
