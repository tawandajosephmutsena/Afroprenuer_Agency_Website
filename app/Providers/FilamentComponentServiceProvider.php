<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Filament\Facades\Filament;

class FilamentComponentServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Filament::registerRenderHook(
            'scripts.start',
            function () {
                return '<script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>';
            }
        );
    }

    public function register()
    {
        //
    }
}