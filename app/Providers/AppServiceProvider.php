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
        // Hanya paksa HTTPS di production atau jika FORCE_HTTPS=true secara eksplisit
        // Bug sebelumnya: default true menyebabkan HTTPS selalu dipaksa di local
        // sehingga session cookie tidak terbaca setelah redirect (mismatch http vs https)
        if (env('APP_ENV') === 'production' || env('FORCE_HTTPS', false) === true) {
            URL::forceScheme('https');
        }
    }
}
