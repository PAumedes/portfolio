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
        // Ensure view cache path is configured before ViewServiceProvider runs
        $this->app->make('config')->set('view', [
            'paths' => [resource_path('views')],
            'compiled' => storage_path('framework/views'),
        ]);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Suppress tempnam() notice from FrankenPHP in Docker (returns fallback, not an error).
        // This is a known FrankenPHP quirk that's safe to ignore in both dev and production.
        error_reporting(error_reporting() & ~E_WARNING);

        // Ensure view cache path is set for Blade compiler
        if (!config('view.compiled')) {
            $this->app['config']['view.compiled'] = storage_path('framework/views');
        }
    }
}
