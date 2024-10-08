<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'location_id',
    ];

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['location', 'tiers'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the notifications for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Get the location that the user belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    /**
     * Relationship with tiers.
     */
    public function tiers()
    {
        return $this->belongsToMany(Tier::class, 'user_tiers')->withPivot('status');
    }

    /**
     * Check if the user has a specific tier.
     *
     * @param string $tierName
     * @param string $status (default is 'active')
     * @return bool
     */
    public function hasTier(string $tierName, string $status = 'active'): bool
    {
        return $this->tiers()->where('name', $tierName)->wherePivot('status', $status)->exists();
    }

    /**
     * Check if the user has any of the specified tiers.
     *
     * @param array $tierNames
     * @param string $status (default is 'active')
     * @return bool
     */
    public function hasAnyTier(array $tierNames, string $status = 'active'): bool
    {
        return $this->tiers()->whereIn('name', $tierNames)->wherePivot('status', $status)->exists();
    }

    /**
     * Get the tier key values for the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tierValues()
    {
        return $this->hasMany(UserTierKeyValue::class);
    }
}
