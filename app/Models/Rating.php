<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'destinasi_id', 'skor_rating', 'komentar'
    ];

    protected function casts(): array
    {
        return [
            'skor_rating' => 'decimal:2',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function destinasi()
    {
        return $this->belongsTo(Destinasi::class);
    }

    public function getReviewAttribute(): ?string
    {
        return $this->komentar;
    }

    public function getRatingAttribute(): ?float
    {
        return is_null($this->skor_rating) ? null : (float) $this->skor_rating;
    }

    public function getRateableAttribute(): ?Destinasi
    {
        return $this->destinasi;
    }

    public function getRateableTypeAttribute(): string
    {
        return match ($this->destinasi?->tipe) {
            'kuliner' => 'Kuliner',
            'penginapan' => 'Penginapan',
            default => 'Destinasi',
        };
    }

    /**
     * Calculate Bayesian Average untuk destinasi
     * Formula: (C × m + S × r) / (C + S)
     * 
     * Dimana:
     * - C = minimum votes untuk kepercayaan penuh (default: 50)
     * - m = average rating seluruh destinasi
     * - S = total votes untuk item ini
     * - r = average rating item ini
     */
    public static function calculateBayesianAverage($destinasiId, $confidenceThreshold = 50)
    {
        // Hitung global average rating dari semua destinasi
        $globalAverage = Rating::where('destinasi_id', '!=', null)
            ->avg('skor_rating') ?? 0;
        
        // Hitung rating item ini
        $itemRating = Rating::where('destinasi_id', $destinasiId)->avg('skor_rating') ?? 0;
        $itemVotes = Rating::where('destinasi_id', $destinasiId)->count();
        
        // Formula Bayesian Average
        $bayesianAvg = ($confidenceThreshold * $globalAverage + $itemVotes * $itemRating) 
                        / ($confidenceThreshold + $itemVotes);
        
        return round($bayesianAvg, 2);
    }

    /**
     * Update rating destinasi menggunakan Bayesian Average
     */
    public static function updateDestinationRating($destinasiId)
    {
        $bayesianAvg = self::calculateBayesianAverage($destinasiId);
        
        Destinasi::where('id', $destinasiId)->update([
            'rating_destinasi' => $bayesianAvg
        ]);
    }
}