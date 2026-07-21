<?php

namespace App\Services;

use App\Models\Destinasi;

class DijkstraService
{
    /**
     * Menghitung rute multi-destinasi berdasarkan budget dan koordinat wilayah lintasan.
     * Menggunakan Greedy Nearest-Neighbor dari koordinat Latitude/Longitude model Destinasi.
     */
    public function calculateRoute($startName, $endName, $destinations)
    {
        // 1. Ambil data koordinat untuk Titik Awal dan Titik Akhir langsung dari DB
        $startDest = Destinasi::where('nama_destinasi', 'LIKE', '%' . trim($startName) . '%')->first();
        $endDest   = Destinasi::where('nama_destinasi', 'LIKE', '%' . trim($endName) . '%')->first();

        if (!$startDest || !$endDest) {
            return ['error' => "Destinasi awal '$startName' atau akhir '$endName' tidak ditemukan di database."];
        }

        // 2. Tentukan batasan wilayah lintasan (Bounding Box) berdasarkan posisi Start dan End
        $minLat = min((float) $startDest->latitude, (float) $endDest->latitude) - 0.02;
        $maxLat = max((float) $startDest->latitude, (float) $endDest->latitude) + 0.02;
        $minLng = min((float) $startDest->longitude, (float) $endDest->longitude) - 0.02;
        $maxLng = max((float) $startDest->longitude, (float) $endDest->longitude) + 0.02;

        // 3. Ambil semua destinasi dari database yang berada di dalam koridor area perjalanan
        $candidateNodes = Destinasi::whereBetween('latitude', [$minLat, $maxLat])
            ->whereBetween('longitude', [$minLng, $maxLng])
            ->get();

        if ($candidateNodes->isEmpty()) {
            $candidateNodes = collect([$startDest, $endDest]);
        }

        if (!$candidateNodes->contains('id', $startDest->id)) {
            $candidateNodes->push($startDest);
        }
        if (!$candidateNodes->contains('id', $endDest->id)) {
            $candidateNodes->push($endDest);
        }

        // 4. Hitung rute mampir-mampir (Nearest Neighbor) dari Titik Start ke End
        $visited = [];
        $current  = $startDest;
        $visited[] = $current;

        $waypoints = $candidateNodes->filter(function ($item) use ($startDest, $endDest) {
            return $item->id !== $startDest->id && $item->id !== $endDest->id;
        })->values();

        while ($waypoints->isNotEmpty()) {
            $nearestIdx = null;
            $minDist    = INF;

            foreach ($waypoints as $idx => $node) {
                $dist = sqrt(
                    pow((float) $node->latitude - (float) $current->latitude, 2) +
                    pow((float) $node->longitude - (float) $current->longitude, 2)
                );
                if ($dist < $minDist) {
                    $minDist    = $dist;
                    $nearestIdx = $idx;
                }
            }

            if ($nearestIdx !== null) {
                $current    = $waypoints[$nearestIdx];
                $visited[]  = $current;
                $waypoints->forget($nearestIdx);
                $waypoints = $waypoints->values();
            } else {
                break;
            }
        }

        if ($startDest->id !== $endDest->id) {
            $visited[] = $endDest;
        }

        return $visited;
    }
}