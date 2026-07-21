<?php

namespace App\Observers;

use App\Models\Rating;

/**
 * RatingObserver: Auto-update Bayesian Average rating ketika ada rating baru
 * 
 * Lifecycle hooks:
 * - created: Setelah rating disimpan ke database
 * - updated: Setelah rating diupdate
 * - deleted: Setelah rating dihapus
 */
class RatingObserver
{
    /**
     * Update destination rating setelah rating baru ditambahkan
     */
    public function created(Rating $rating): void
    {
        if ($rating->destinasi_id) {
            Rating::updateDestinationRating($rating->destinasi_id);
        }
    }

    /**
     * Update destination rating setelah rating diubah
     */
    public function updated(Rating $rating): void
    {
        if ($rating->destinasi_id) {
            Rating::updateDestinationRating($rating->destinasi_id);
        }
    }

    /**
     * Update destination rating setelah rating dihapus
     */
    public function deleted(Rating $rating): void
    {
        if ($rating->destinasi_id) {
            Rating::updateDestinationRating($rating->destinasi_id);
        }
    }
}
