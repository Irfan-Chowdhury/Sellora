<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        parent::boot();

        // ✅ Define custom macro
        Route::macro('resourceWithStatus', function ($name, $controller) {

            // normal resource routes
            Route::resource($name, $controller);

            // extra methods
            Route::patch("$name/{id}/active", [$controller, 'makeActive'])
                ->name("$name.active");

            Route::patch("$name/{id}/inactive", [$controller, 'makeInactive'])
                ->name("$name.inactive");
        });
    }
}
