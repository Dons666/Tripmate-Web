<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PreferenceController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinasiController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\TravelPlanController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\RecommendationDebugController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Public
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');


/*
|--------------------------------------------------------------------------
| Authenticated
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/search', [DestinasiController::class, 'search'])->name('destinasi.search');

    Route::get('/destinasi/{id}', [DestinasiController::class, 'show'])->name('destinasi.show');

    Route::post('/destinasi/{id}/rate', [DestinasiController::class, 'storeRating'])->name('destinasi.rate');
    Route::post('/ratings/{type}/{id}', [RatingController::class, 'store'])->name('ratings.store');

    Route::get('/preference', [PreferenceController::class, 'create'])->name('preference.create');
    Route::post('/preference', [PreferenceController::class, 'store'])->name('preference.store');

    Route::get('/recommendations', [RecommendationController::class, 'index'])->name('recommendations.index');

    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/toggle', [BookmarkController::class, 'toggle'])->name('bookmarks.toggle');

    Route::resource('travel-plans', TravelPlanController::class)
        ->except(['create','edit','update']);

    Route::post('/travel-plans/{travelPlan}/add-destinasi',
        [TravelPlanController::class,'addDestinasi'])
        ->name('travel-plans.addDestinasi');

    Route::delete('/travel-plans/{travelPlan}/destinasi/{destinasi}',
        [TravelPlanController::class,'removeDestinasi'])
        ->name('travel-plans.removeDestinasi');

    Route::post('/travel-plans/{travelPlan}/expenses',
        [ExpenseController::class,'store'])
        ->name('expenses.store');

    Route::delete('/expenses/{expense}',
        [ExpenseController::class,'destroy'])
        ->name('expenses.destroy');

    Route::get('/profile',[ProfileController::class,'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class,'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class,'destroy'])->name('profile.destroy');
    Route::get(
    '/recommendation/debug',
        [RecommendationDebugController::class, 'index']
)->middleware('auth')
 ->name('recommendation.debug');

});

Route::middleware(['auth'])->group(function () {

    // Rencana Perjalanan
    Route::get('/travel-plans', [TravelPlanController::class, 'index'])->name('travel-plans.index');
    Route::post('/travel-plans', [TravelPlanController::class, 'store'])->name('travel-plans.store');
    Route::get('/travel-plans/{travelPlan}', [TravelPlanController::class, 'show'])->name('travel-plans.show');
    Route::post('/travel-plans/{travelPlan}/add-destinasi', [TravelPlanController::class, 'addDestinasi'])->name('travel-plans.addDestinasi');
    Route::post('/travel-plans/quick-add', [TravelPlanController::class, 'quickAdd'])->name('travel-plans.quick-add');
    Route::post('/travel-plans/{travelPlan}/complete', [TravelPlanController::class, 'complete'])->name('travel-plans.complete');
    Route::delete('/travel-plans/{travelPlan}/destinasi/{destinasi}', [TravelPlanController::class, 'removeDestinasi'])->name('travel-plans.removeDestinasi');
    Route::delete('/travel-plans/{travelPlan}', [TravelPlanController::class, 'destroy'])->name('travel-plans.destroy');

    // Admin routes
    Route::prefix('admin')
        ->name('admin.')
        ->middleware('admin')
        ->group(function () {
            Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
            Route::get('/places', [AdminController::class, 'placesIndex'])->name('places.index');

            Route::get('/destinations/create', [AdminController::class, 'createDestination'])->name('destinations.create');
            Route::post('/destinations', [AdminController::class, 'storeDestination'])->name('destinations.store');
            Route::get('/destinations/{destination}', [AdminController::class, 'showDestination'])->name('destinations.show');
            Route::get('/destinations/{destination}/edit', [AdminController::class, 'editDestination'])->name('destinations.edit');
            Route::put('/destinations/{destination}', [AdminController::class, 'updateDestination'])->name('destinations.update');
            Route::delete('/destinations/{destination}', [AdminController::class, 'destroyDestination'])->name('destinations.destroy');

            Route::get('/culinaries/create', [AdminController::class, 'createCulinary'])->name('culinaries.create');
            Route::post('/culinaries', [AdminController::class, 'storeCulinary'])->name('culinaries.store');
            Route::get('/culinaries/{culinary}', [AdminController::class, 'showCulinary'])->name('culinaries.show');
            Route::get('/culinaries/{culinary}/edit', [AdminController::class, 'editCulinary'])->name('culinaries.edit');
            Route::put('/culinaries/{culinary}', [AdminController::class, 'updateCulinary'])->name('culinaries.update');
            Route::delete('/culinaries/{culinary}', [AdminController::class, 'destroyCulinary'])->name('culinaries.destroy');

            Route::get('/stays/create', [AdminController::class, 'createStay'])->name('stays.create');
            Route::post('/stays', [AdminController::class, 'storeStay'])->name('stays.store');
            Route::get('/stays/{stay}', [AdminController::class, 'showStay'])->name('stays.show');
            Route::get('/stays/{stay}/edit', [AdminController::class, 'editStay'])->name('stays.edit');
            Route::put('/stays/{stay}', [AdminController::class, 'updateStay'])->name('stays.update');
            Route::delete('/stays/{stay}', [AdminController::class, 'destroyStay'])->name('stays.destroy');

            Route::get('/comments', [AdminController::class, 'commentsIndex'])->name('comments.index');
            Route::delete('/comments/{comment}', [AdminController::class, 'destroyComment'])->name('comments.destroy');
            Route::post('/comments/{comment}/warning', [AdminController::class, 'sendWarning'])->name('comments.warning');

            Route::get('/users', [AdminController::class, 'usersIndex'])->name('users.index');
            Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
            Route::post('/users/{user}/reset-password', [AdminController::class, 'resetUserPassword'])->name('users.reset-password');
            Route::post('/users/{user}/status', [AdminController::class, 'updateUserStatus'])->name('users.update-status');

            Route::get('/logs', [AdminController::class, 'logs'])->name('logs');
        });

    Route::post('/notifications/mark-all-read', [AdminController::class, 'markAllNotificationsRead'])
        ->name('notifications.mark-all-read');

});

require __DIR__.'/auth.php';