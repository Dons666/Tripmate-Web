<?php

namespace App\Providers;

use App\Models\Rating;
use App\Observers\RatingObserver;
use Illuminate\Support\Facades\URL;
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

        // Paksa HTTPS di lingkungan produksi (Domainesia)
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

