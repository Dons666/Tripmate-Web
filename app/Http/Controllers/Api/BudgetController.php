<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BudgetRecommendationService;
use App\Services\DijkstraService;
use App\Models\TravelPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BudgetController extends Controller
{
    protected BudgetRecommendationService $budgetService;
    protected DijkstraService $dijkstraService;

    public function __construct(
        BudgetRecommendationService $budgetService,
        DijkstraService $dijkstraService
    ) {
        $this->budgetService   = $budgetService;
        $this->dijkstraService = $dijkstraService;
    }

    /**
     * Rekomendasi destinasi berdasarkan budget, kategori, dan kota.
     *
     * POST /api/budget-recommendation
     * Body: { budget: float, kategori?: string, kota?: string }
     */
    public function recommend(Request $request)
    {
        $request->validate([
            'budget'   => 'required|numeric|min:0',
            'kategori' => 'nullable|string|max:100',
            'kota'     => 'nullable|string|max:100',
        ]);

        $data = $this->budgetService->recommend(
            $request->budget,
            $request->kategori,
            $request->kota,
        );

        return response()->json([
            'status'           => 'success',
            'recommendations'  => $data['recommendations'],
            'total_cost'       => $data['total_cost'],
            'remaining_budget' => $data['remaining_budget'],
            'count'            => $data['count'],
            'budget_max'       => $data['budget_max'],
        ]);
    }

    /**
     * Hitung rute terintegrasi berdasarkan budget dan titik awal–akhir.
     *
     * POST /api/integrated-route
     * Body: { start: string, end: string, budget: float, kategori?: string, kota?: string }
     */
    public function getIntegratedRoute(Request $request)
    {
        $request->validate([
            'start'    => 'required|string',
            'end'      => 'required|string',
            'budget'   => 'required|numeric',
            'kategori' => 'nullable|string',
            'kota'     => 'nullable|string',
        ]);

        // 1. Dapatkan kandidat destinasi dalam budget
        $data         = $this->budgetService->recommend(
            $request->budget,
            $request->kategori,
            $request->kota,
        );
        $destinations = $data['recommendations'];

        // 2. Hitung rute waypoint berdasarkan koridor geografis
        $rawRoute = $this->dijkstraService->calculateRoute(
            $request->start,
            $request->end,
            $destinations
        );

        if (is_array($rawRoute) && isset($rawRoute['error'])) {
            return response()->json(['message' => $rawRoute['error']], 404);
        }

        // 3. Pembatasan budget: akumulasikan biaya per destinasi
        $finalRoute      = [];
        $accumulatedCost = 0;
        $maxBudget       = (float) $request->budget;

        foreach ($rawRoute as $index => $place) {
            $cost = (float) ($place->harga ?? 0);

            // Titik awal dan akhir selalu dimasukkan
            if ($index === 0 || $index === (count($rawRoute) - 1)) {
                $accumulatedCost += $cost;
                $finalRoute[] = $place;
                continue;
            }

            if (($accumulatedCost + $cost) <= $maxBudget) {
                $accumulatedCost += $cost;
                $finalRoute[] = $place;
            }
        }

        $formatted = collect($finalRoute)->map(fn ($d) => [
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
            'status'           => 'success',
            'route'            => $formatted,
            'total_cost'       => $accumulatedCost,
            'remaining_budget' => max(0.0, $maxBudget - $accumulatedCost),
            'total_nodes'      => $formatted->count(),
        ]);
    }

    /**
     * Simpan hasil rute ke Travel Plan.
     *
     * POST /api/save-trip-plan  (auth:sanctum)
     * Body: { nama_perjalanan: string, budget: float, total_cost: float, destinasi_ids: int[] }
     */
    public function saveToPlan(Request $request)
    {
        $request->validate([
            'nama_perjalanan' => 'required|string|max:255',
            'budget'          => 'required|numeric',
            'total_cost'      => 'required|numeric',
            'destinasi_ids'   => 'required|array|min:1',
            'destinasi_ids.*' => 'exists:destinasi,id',
        ]);

        try {
            DB::beginTransaction();

            /** @var \App\Models\TravelPlan $plan */
            $plan = $request->user()->travelPlans()->create([
                'nama_perjalanan' => $request->nama_perjalanan,
                'budget'          => $request->budget,
                'status'          => 'planning',
            ]);

            foreach ($request->destinasi_ids as $destinasiId) {
                $plan->destinasis()->attach($destinasiId);
            }

            DB::commit();

            return response()->json([
                'status'  => 'success',
                'message' => 'Rencana perjalanan berhasil disimpan!',
                'plan'    => $plan->load('destinasis'),
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal menyimpan plan: ' . $e->getMessage());
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal menyimpan rencana perjalanan.',
            ], 500);
        }
    }
}