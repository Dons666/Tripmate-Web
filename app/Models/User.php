<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'avatar',
        'is_active',
        'deactivation_reason_code',
        'deactivation_reason_detail',
        'warning_count',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function preference()
    {
        return $this->hasOne(UserPreference::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function bookmarks()
    {
        return $this->hasMany(Bookmark::class);
    }

    public function searchHistories()
    {
        return $this->hasMany(SearchHistory::class);
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function getUsernameAttribute(): string
    {
        return (string) ($this->name ?? '');
    }

    public function getIsActiveAttribute($value): bool
    {
        if (!is_null($value)) {
            return (bool) $value;
        }

        return true;
    }

    public function getWarningCountAttribute($value): int
    {
        return (int) ($value ?? 0);
    }

        public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function travelPlans()
    {
        return $this->hasMany(TravelPlan::class);
    }
}
