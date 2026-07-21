<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Route;
use App\Services\DijkstraService;

class RouteController extends Controller
{
    protected DijkstraService $dijkstraService;

    public function __construct(DijkstraService $dijkstraService)
    {
        $this->dijkstraService = $dijkstraService;
    }

    /**
     * Hitung rute terpendek antara dua destinasi menggunakan Dijkstra.
     */
    public function shortest($start, $end)
    {
        $routes = Route::all();

        $graph = [];

        foreach ($routes as $route) {
            $graph[$route->source_destination_id]
                  [$route->target_destination_id]
                  = $route->distance;

            $graph[$route->target_destination_id]
                  [$route->source_destination_id]
                  = $route->distance;
        }

        $result = $this->dijkstraService->shortestPath(
            $graph,
            $start,
            $end
        );

        return response()->json($result);
    }
}