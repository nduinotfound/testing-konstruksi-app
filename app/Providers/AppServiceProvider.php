<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
// FIX IMPORT: Di sini letak posisi Facade URL Laravel yang asli, bukan App\Providers\URL
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
        // Paksa semua URL, Route, dan Aset menggunakan skema HTTPS jika diakses lewat terowongan Ngrok
        if (str_contains(request()->url(), 'ngrok-free.app') || str_contains(request()->url(), 'ngrok-free.dev') || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }
    }
}
