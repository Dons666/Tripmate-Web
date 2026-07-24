<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    protected $fillable = [
        'travel_plan_id',
        'destinasi_id',
        'judul',
        'deskripsi',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function travelPlan()
    {
        return $this->belongsTo(TravelPlan::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }
}
