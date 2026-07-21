<?php
//php artisan serve --host=0.0.0.0 --port=8000
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RouteController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\BudgetController;

Route::apiResource(
    'destinations',
    DestinationController::class
);

Route::get(
    '/shortest-route/{start}/{end}',
    [RouteController::class,'shortest']
);

Route::post('/integrated-route', [BudgetController::class, 'getIntegratedRoute']);