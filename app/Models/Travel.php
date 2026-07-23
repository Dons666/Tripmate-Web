<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $table = 'travels';

    protected $fillable = [
        'user_id',
        'nama_travel',
        'slug',
        'layanan',
        'deskripsi',
        'harga_paket',
        'rating',
        'kota',
        'kontak',
        'gambar',
    ];

    protected $casts = [
        'harga_paket' => 'float',
        'rating'      => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travelPlans()
    {
        return $this->hasMany(TravelPlan::class);
    }
}
