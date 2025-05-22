<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

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
        // http scheme forced for local system for running in development environment by Adarsh
        \URL::forceScheme('http');
        Paginator::useBootstrapFive();
        Paginator::useBootstrapFour();
    }
}
