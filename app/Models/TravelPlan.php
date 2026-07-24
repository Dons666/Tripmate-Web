<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TravelPlan extends Model
{
    protected $fillable = [
        'user_id',
        'travel_id',
        'nama_perjalanan',
        'tujuan',
        'catatan',
        'tanggal_mulai',
        'tanggal_selesai',
        'budget',
        'status',
        'is_checkout',
        'foto_sampul',
    ];

    protected $casts = [
        'tanggal_mulai'   => 'date',
        'tanggal_selesai' => 'date',
        'is_checkout'     => 'boolean',
    ];

    public function getTotalExpensesAttribute()
    {
        return $this->expenses()->sum('jumlah');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function destinasis()
    {
        return $this->belongsToMany(Destinasi::class, 'travel_plan_destinasi');
    }

    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class)->orderBy('tanggal')->orderBy('jam_mulai');
    }
}