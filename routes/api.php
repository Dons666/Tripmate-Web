<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DestinasiController;
use App\Http\Controllers\Api\BookmarkController;
use App\Http\Controllers\Api\TravelPlanController;
use App\Http\Controllers\Api\ExpenseController;
use App\Http\Controllers\Api\BudgetController;
use App\Http\Controllers\Api\RecommendationController;
use App\Http\Controllers\Api\RouteController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Auth
Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login',    [AuthController::class, 'login']);
});

// Destinasi (read-only public)
Route::get('destinasi',      [DestinasiController::class, 'index']);
Route::get('destinasi/{id}', [DestinasiController::class, 'show']);

// Algoritma budget (public)
Route::post('budget-recommendation', [BudgetController::class, 'recommend']);
Route::post('integrated-route',      [BudgetController::class, 'getIntegratedRoute']);

// Algoritma Dijkstra / Nearest-Neighbor (public)
Route::get('dijkstra/{start}/{end}', [RouteController::class, 'show']);

// Health check
Route::get('test', fn () => response()->json(['message' => 'API TripMate OK']));

/*
|--------------------------------------------------------------------------
| Authenticated Routes (Sanctum)
|--------------------------------------------------------------------------
*/

Route::middleware('auth:sanctum')->group(function () {

    // Auth
    Route::post('auth/logout', [AuthController::class, 'logout']);
    Route::get('auth/me',      [AuthController::class, 'me']);

    // Rekomendasi TF-IDF (personalized)
    Route::get('recommendations', [RecommendationController::class, 'index']);

    // Bookmarks
    Route::get('bookmarks',         [BookmarkController::class, 'index']);
    Route::post('bookmarks/toggle', [BookmarkController::class, 'toggle']);
    Route::delete('bookmarks/{id}', [BookmarkController::class, 'destroy']);

    // Travel Plans
    Route::get('travel-plans',              [TravelPlanController::class, 'index']);
    Route::post('travel-plans',             [TravelPlanController::class, 'store']);
    Route::get('travel-plans/{id}',         [TravelPlanController::class, 'show']);
    Route::delete('travel-plans/{id}',      [TravelPlanController::class, 'destroy']);
    Route::post(
        'travel-plans/{id}/destinasi',
        [TravelPlanController::class, 'addDestinasi']
    );
    Route::delete(
        'travel-plans/{planId}/destinasi/{destinasiId}',
        [TravelPlanController::class, 'removeDestinasi']
    );

    // Expenses
    Route::get('expenses',          [ExpenseController::class, 'index']);
    Route::post('expenses',         [ExpenseController::class, 'store']);
    Route::delete('expenses/{id}',  [ExpenseController::class, 'destroy']);

    // Simpan rute budget ke Travel Plan
    Route::post('save-trip-plan', [BudgetController::class, 'saveToPlan']);

});