<?php

namespace App\Services;

use App\Models\Destinasi;

class BudgetRecommendationService
{
    /**
     * Rekomendasikan destinasi berdasarkan budget maksimum, kategori, dan kota (semua opsional).
     *
     * Mengembalikan destinasi yang harganya <= budget, diurutkan dari yang termurah,
     * beserta akumulasi biaya dan sisa budget.
     *
     * @param  float       $budget    Budget maksimum total perjalanan
     * @param  string|null $kategori  Filter kategori (e.g. 'Wisata Alam')
     * @param  string|null $kota      Filter kota (e.g. 'Bandung')
     * @return array
     */
    public function recommend($budget, $kategori = null, $kota = null): array
    {
        $query = Destinasi::query();

        // Filter kategori (partial match)
        if ($kategori) {
            $query->where('kategori', 'LIKE', '%' . $kategori . '%');
        }

        // Filter kota (partial match)
        if ($kota) {
            $query->where('kota', 'LIKE', '%' . $kota . '%');
        }

        // Hanya destinasi yang harga tiket-nya <= budget
        $query->where('harga', '<=', $budget);

        // Urutkan dari yang termurah agar budget terpakai secara efisien
        $query->orderBy('harga', 'asc');

        $destinations = $query
            ->select([
                'id', 'nama_destinasi', 'tipe', 'kategori', 'kota',
                'harga', 'deskripsi', 'gambar', 'rating_destinasi',
                'hidden_gem', 'latitude', 'longitude',
            ])
            ->limit(20)
            ->get();

        // Akumulasi biaya hingga budget habis
        $selectedDestinations = collect();
        $accumulatedCost      = 0.0;
        $maxBudget            = (float) $budget;

        foreach ($destinations as $dest) {
            $cost = (float) $dest->harga;
            if (($accumulatedCost + $cost) <= $maxBudget) {
                $accumulatedCost += $cost;
                $selectedDestinations->push($dest);
            }
        }

        $remainingBudget = $maxBudget - $accumulatedCost;

        return [
            'recommendations'  => $selectedDestinations,
            'total_cost'       => $accumulatedCost,
            'remaining_budget' => max(0.0, $remainingBudget),
            'count'            => $selectedDestinations->count(),
            'budget_max'       => $maxBudget,
        ];
    }
}