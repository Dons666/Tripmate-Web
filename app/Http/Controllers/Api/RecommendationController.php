<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\GeminiFilterService;
use App\Services\BudgetRecommendationService;
use App\Services\DijkstraService;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    protected GeminiFilterService $geminiService;
    protected BudgetRecommendationService $budgetService;
    protected DijkstraService $dijkstraService;

    public function __construct(
        GeminiFilterService $geminiService,
        BudgetRecommendationService $budgetService,
        DijkstraService $dijkstraService
    ) {
        $this->geminiService = $geminiService;
        $this->budgetService = $budgetService;
        $this->dijkstraService = $dijkstraService;
    }

    public function generateItinerary(Request $request)
    {
        $request->validate([
            'kota' => 'required|string',
            'kategori' => 'required|string',
            'budget' => 'required|numeric|min:0',
            'titik_awal' => 'required|string'
        ]);

        $kota = $request->input('kota');
        $kategori = $request->input('kategori');
        $budget = (float) $request->input('budget');
        $titikAwal = $request->input('titik_awal');

        // 1. Minta rekomendasi tempat wisata dari Gemini API
        $rawPlaces = $this->geminiService->getRecommendedPlaces($kota, $kategori);

        if (empty($rawPlaces) || !is_array($rawPlaces)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan data rekomendasi dari Gemini API.'
            ], 500);
        }

        // Normalisasi key
        $normalizedPlaces = array_map(function ($item) {
            return [
                'nama_tempat' => $item['nama_tempat'] ?? $item['nama'] ?? 'Tempat Wisata',
                'estimasi_biaya' => (float) ($item['estimasi_biaya'] ?? $item['biaya'] ?? 0)
            ];
        }, $rawPlaces);

        // 2. Filter tempat menggunakan Algoritma Greedy berbasis Budget
        $budgetResult = $this->budgetService->filterByBudget($normalizedPlaces, $budget);
        $destinasiTerpilih = $budgetResult['destinasi_terpilih'] ?? [];

        if (empty($destinasiTerpilih)) {
            return response()->json([
                'status' => 'success',
                'message' => 'Budget tidak cukup untuk mengunjungi destinasi rekomendasi.',
                'budget_info' => [
                    'total_budget' => $budget,
                    'total_terpakai' => 0,
                    'sisa_budget' => $budget
                ],
                'rute_perjalanan' => []
            ]);
        }

        // 3. Susun daftar nama tempat (Titik Awal + Destinasi Terpilih Greedy)
        $namaTempatList = array_merge([$titikAwal], array_column($destinasiTerpilih, 'nama_tempat'));

        // 4. Hitung Jarak Riil & Rute Terpendek Dijkstra
        $distanceMatrix = $this->dijkstraService->getDistanceMatrix($namaTempatList);
        $routeResult = $this->dijkstraService->findShortestRoute($namaTempatList, $distanceMatrix, 0);

        return response()->json([
            'status' => 'success',
            'budget_info' => [
                'total_budget' => $budget,
                'total_terpakai' => $budgetResult['total_biaya'] ?? 0,
                'sisa_budget' => $budgetResult['sisa_budget'] ?? $budget
            ],
            'destinasi_terpilih' => $destinasiTerpilih,
            'rute_terpendek' => [
                'urutan_perjalanan' => $routeResult['urutan_rute'] ?? [],
                'detail_perjalanan' => $routeResult['detail_rute'] ?? [],
                'total_jarak' => ($routeResult['total_jarak_km'] ?? 0) . ' KM'
            ]
        ]);
    }
}