<?php

namespace App\Providers;

use App\Models\Rating;
use App\Observers\RatingObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Observer untuk auto-update Bayesian Average rating
        Rating::observe(RatingObserver::class);
    }
}
