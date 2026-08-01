<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
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
        // Admin components render as <x-admin::name>, kept out of the
        // public site's resources/views/components namespace.
        Blade::anonymousComponentPath(resource_path('views/admin/components'), 'admin');
    }
}
