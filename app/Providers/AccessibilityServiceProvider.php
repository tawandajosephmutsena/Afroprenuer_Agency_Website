<?php

namespace App\Providers;

use App\Services\AccessibilityService;
use Illuminate\Support\ServiceProvider;

class AccessibilityServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(AccessibilityService::class, function ($app) {
            return new AccessibilityService(auth()->user());
        });
    }

    public function boot()
    {
        //
    }
}