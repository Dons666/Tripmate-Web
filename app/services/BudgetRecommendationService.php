<?php

namespace App\Services;

use App\Models\Destinasi;

class BudgetRecommendationService
{
    /**
     * Rekomendasikan destinasi berdasarkan budget maksimum dan kategori (opsional).
     */
    public function recommend($budget, $kategori = null)
    {
        $query = Destinasi::query();

        if ($kategori) {
            $query->where('kategori', $kategori);
        }

        $query->where('harga', '<=', $budget);

        $destinations = $query->limit(20)->get();

        $totalCost = $destinations->sum('harga');

        return [
            'recommendations' => $destinations,
            'total_cost'      => $totalCost,
        ];
    }
}