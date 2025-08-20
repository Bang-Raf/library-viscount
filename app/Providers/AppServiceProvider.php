<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\ThemeHelper;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;

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
        View::share('activeTheme', ThemeHelper::getActiveTheme());

        // Protect the login route from brute-force attempts
        RateLimiter::for('login', function (Request $request) {
            $username = (string) $request->input('username');
            return [
                Limit::perMinute(5)->by($username.$request->ip()),
            ];
        });
    }
}
