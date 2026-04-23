<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
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
        /**
         * Paksa semua link (CSS, JS, Form) menggunakan HTTPS di Railway.
         * Ini akan menghilangkan peringatan "The information you’re about to submit is not secure".
         */
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}