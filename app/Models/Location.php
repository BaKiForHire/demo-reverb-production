<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;

    protected $fillable = ['street_address', 'coordinates', 'state', 'city', 'postal_code'];

    // If you want to separate latitude and longitude in coordinates
    protected $casts = [
        'coordinates' => 'json', // Store lat/long as a JSON object.
    ];

    public function auctions()
    {
        return $this->hasMany(Auction::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
