<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 

class AppServiceProvider extends ServiceProvider
{
    public function register() { }

    public function boot()
    {
        // Paksa semua URL (form, asset, link) jadi HTTPS jika di produksi
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}