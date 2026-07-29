<?php

namespace App\Services;

class BudgetRecommendationService
{
    /**
     * Memilih tempat wisata menggunakan Algoritma Greedy berdasarkan Budget.
     */
    public function filterByBudget(array $places, float $userBudget): array
    {
        if (empty($places)) {
            return [
                'total_biaya' => 0,
                'sisa_budget' => $userBudget,
                'destinasi_terpilih' => []
            ];
        }

        // Strategi Greedy: Urutkan tempat berdasarkan estimasi_biaya terendah
        usort($places, function ($a, $b) {
            return ($a['estimasi_biaya'] ?? 0) <=> ($b['estimasi_biaya'] ?? 0);
        });

        $selectedPlaces = [];
        $currentCost = 0;

        foreach ($places as $place) {
            $biaya = $place['estimasi_biaya'] ?? 0;

            if ($currentCost + $biaya <= $userBudget) {
                $selectedPlaces[] = $place;
                $currentCost += $biaya;
            }
        }

        return [
            'total_biaya' => $currentCost,
            'sisa_budget' => $userBudget - $currentCost,
            'destinasi_terpilih' => $selectedPlaces
        ];
    }
}