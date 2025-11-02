<?php

namespace App\Providers;

// use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;


class RouteServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

   
    public function boot(): void
    {
        parent::boot();

        // ✅ Define custom macro
        Route::macro('resourceWithStatus', function ($name, $controller) {

            // Regular resource
            Route::resource($name, $controller);

            // Extract singular form automatically
            $param = Str::singular($name);

            // Extra routes
            Route::patch("$name/{{$param}}/active", [$controller, 'makeActive'])
                ->name("$name.active");

            Route::patch("$name/{{$param}}/inactive", [$controller, 'makeInactive'])
                ->name("$name.inactive");
        });
    }

}
