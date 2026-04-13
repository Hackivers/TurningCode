<?php

namespace App\Providers;

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
        // Railway (dan hosting lain) menggunakan reverse proxy dengan HTTPS.
        // PHP di belakang proxy hanya melihat HTTP, sehingga Laravel generate
        // asset URL pakai http:// → browser blokir karena mixed content.
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}

