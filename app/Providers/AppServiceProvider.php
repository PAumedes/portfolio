<?php

namespace App\Providers;

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
        // Suppress tempnam() notice from FrankenPHP in Docker (returns fallback, not an error).
        // This is a known FrankenPHP quirk that's safe to ignore in both dev and production.
        error_reporting(error_reporting() & ~E_WARNING);
    }
}
