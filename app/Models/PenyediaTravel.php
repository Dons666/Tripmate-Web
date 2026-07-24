<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenyediaTravel extends Model
{
    use HasFactory;

    protected $table = 'penyedia_travel';

    protected $fillable = [
        'nama_travel',
        'email',
        'password',
        'alamat_travel',
        'kota_asal_travel',
        'jenis_kendaraan',
        'foto_kendaraan',
        'harga',
        'jadwal_ketersediaan',
        'rekening',
        'surat_izin_usaha_travel',
        'ktp_pemilik',
        'nomor_hp_pemilik_travel',
        'status',
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'decimal:2',
            'password' => 'hashed',
        ];
    }

    public function getFotosArrayAttribute(): array
    {
        if (empty($this->foto_kendaraan)) return [];
        $decoded = json_decode($this->foto_kendaraan, true);
        if (is_array($decoded)) return $decoded;
        return [$this->foto_kendaraan];
    }
}
