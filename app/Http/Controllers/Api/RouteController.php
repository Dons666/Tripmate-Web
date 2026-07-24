<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\DijkstraService;
use Illuminate\Http\JsonResponse;

class RouteController extends Controller
{
    protected DijkstraService $dijkstraService;

    public function __construct(DijkstraService $dijkstraService)
    {
        $this->dijkstraService = $dijkstraService;
    }

    /**
     * Hitung rute terpendek (Nearest-Neighbor / Dijkstra-like)
     * antara dua destinasi berdasarkan nama.
     *
     * GET /api/dijkstra/{start}/{end}
     *
     * @param  string  $start  Nama destinasi awal (URL-encoded)
     * @param  string  $end    Nama destinasi akhir (URL-encoded)
     */
    public function show(string $start, string $end): JsonResponse
    {
        $startName = urldecode($start);
        $endName   = urldecode($end);

        $route = $this->dijkstraService->calculateRoute($startName, $endName, collect());

        if (is_array($route) && isset($route['error'])) {
            return response()->json([
                'status'  => 'error',
                'message' => $route['error'],
            ], 404);
        }

        $nodes = collect($route);

        // Hitung total jarak Euclidean antar node berurutan
        $totalDistance = 0.0;
        for ($i = 0; $i < $nodes->count() - 1; $i++) {
            $a = $nodes[$i];
            $b = $nodes[$i + 1];
            $totalDistance += sqrt(
                pow((float) $b->latitude - (float) $a->latitude, 2) +
                pow((float) $b->longitude - (float) $a->longitude, 2)
            );
        }

        // Format tiap node untuk response
        $formatted = $nodes->map(fn ($d) => [
            'id'             => $d->id,
            'nama_destinasi' => $d->nama_destinasi,
            'kategori'       => $d->kategori,
            'kota'           => $d->kota,
            'harga'          => (float) $d->harga,
            'latitude'       => (float) $d->latitude,
            'longitude'      => (float) $d->longitude,
            'gambar'         => $d->image_url,
        ]);

        return response()->json([
            'status'         => 'success',
            'route'          => $formatted,
            'total_nodes'    => $nodes->count(),
            'total_distance' => round($totalDistance, 6),
            'total_cost'     => (float) $nodes->sum('harga'),
        ]);
    }
}