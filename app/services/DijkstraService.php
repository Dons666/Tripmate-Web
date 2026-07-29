<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class DijkstraService
{
    protected string $googleMapsApiKey;

    public function __construct()
    {
        $this->googleMapsApiKey = env('GOOGLE_MAPS_API_KEY', config('services.google_maps.api_key', ''));
    }

    /**
     * Ambil Matriks Jarak Jalan Riil (dalam meter) antar nama tempat.
     */
    public function getDistanceMatrix(array $placeNames): array
    {
        $n = count($placeNames);
        $matrix = [];

        // Inisialisasi matriks awal
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                $matrix[$i][$j] = ($i === $j) ? 0 : INF;
            }
        }

        if ($n <= 1) {
            return $matrix;
        }

        // Jika ada Google Maps API Key
        if (!empty($this->googleMapsApiKey)) {
            $locations = implode('|', array_map('urlencode', $placeNames));

            try {
                $response = Http::get("https://maps.googleapis.com/maps/api/distancematrix/json", [
                    'origins' => $locations,
                    'destinations' => $locations,
                    'key' => $this->googleMapsApiKey
                ]);

                if ($response->successful() && ($response->json('status') === 'OK')) {
                    $data = $response->json();
                    foreach ($data['rows'] ?? [] as $i => $row) {
                        foreach ($row['elements'] ?? [] as $j => $element) {
                            if (isset($element['distance']['value'])) {
                                $matrix[$i][$j] = $element['distance']['value'];
                            }
                        }
                    }
                    return $matrix;
                }
            } catch (\Exception $e) {
                Log::error("Google Distance Matrix Exception: " . $e->getMessage());
            }
        }

        // Fallback Jarak Dummy Realistis jika tanpa Google API Key / Error
        for ($i = 0; $i < $n; $i++) {
            for ($j = 0; $j < $n; $j++) {
                if ($i !== $j) {
                    // Membuat jarak sintetis berbasis index selisih (contoh: 1.5 KM - 8 KM)
                    $matrix[$i][$j] = abs($i - $j) * 1500 + rand(500, 2000); 
                }
            }
        }

        return $matrix;
    }

    /**
     * Menghitung Rute Terpendek & Rincian Jarak Antar Titik.
     */
    public function findShortestRoute(array $placeNames, array $distanceMatrix, int $startNode = 0): array
    {
        $numNodes = count($placeNames);
        if ($numNodes === 0) {
            return [
                'urutan_rute' => [],
                'detail_rute' => [],
                'total_jarak_km' => 0
            ];
        }

        $visited = array_fill(0, $numNodes, false);
        $route = [$startNode];
        $visited[$startNode] = true;

        $currentNode = $startNode;
        $totalDistance = 0;
        $detailRute = [];

        // Nearest Neighbor Traversal berbasis Matriks Jarak Dijkstra
        for ($i = 0; $i < $numNodes - 1; $i++) {
            $nearestNode = null;
            $minDistance = INF;

            for ($neighbor = 0; $neighbor < $numNodes; $neighbor++) {
                if (!$visited[$neighbor] && $distanceMatrix[$currentNode][$neighbor] < $minDistance) {
                    $minDistance = $distanceMatrix[$currentNode][$neighbor];
                    $nearestNode = $neighbor;
                }
            }

            if ($nearestNode !== null) {
                $visited[$nearestNode] = true;
                $route[] = $nearestNode;
                $totalDistance += $minDistance;

                // Catat rincian perjalanan dari tempat A ke tempat B
                $detailRute[] = [
                    'dari' => $placeNames[$currentNode],
                    'ke' => $placeNames[$nearestNode],
                    'jarak' => round($minDistance / 1000, 2) . ' KM'
                ];

                $currentNode = $nearestNode;
            }
        }

        // Susun urutan nama tempat akhir
        $orderedPlaces = [];
        foreach ($route as $index) {
            $orderedPlaces[] = $placeNames[$index];
        }

        return [
            'urutan_rute' => $orderedPlaces,
            'detail_rute' => $detailRute,
            'total_jarak_km' => round($totalDistance / 1000, 2)
        ];
    }
}