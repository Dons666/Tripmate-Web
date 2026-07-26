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

        // Paksa HTTPS di domain produksi (tripmate.my.id) atau saat diakses via HTTPS
        if (str_contains(request()->header('host', ''), 'tripmate.my.id') || request()->isSecure() || request()->server('HTTP_X_FORWARDED_PROTO') === 'https') {
            URL::forceScheme('https');
        }
    }
}

