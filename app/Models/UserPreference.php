<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPreference extends Model
{
    use HasFactory;

    protected $table = 'user_preferences';

    protected $fillable = [
        'user_id',
        'kota_preferensi',
        'minat_wisata',
        'hidden_gem',
        'budget'
    ];

    protected function casts(): array
    {
        return [
            'minat_wisata' => 'array',
            'hidden_gem' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}