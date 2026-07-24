<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Armada extends Model
{
    protected $fillable = [
        'user_id',
        'nama_kendaraan',
        'nomor_polisi',
        'kapasitas_kursi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function travels()
    {
        return $this->hasMany(Travel::class);
    }
}
