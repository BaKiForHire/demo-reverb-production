<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTierKey extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'identifier', 'tier_id', 'is_active', 'data_type', 'validation_rules', 'disabled', 'required'];

    public function tier()
    {
        return $this->belongsTo(Tier::class);
    }
}