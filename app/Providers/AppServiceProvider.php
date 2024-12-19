<?php

namespace App\Providers;

use App\Models\Client;
use App\Models\User;
use Illuminate\Support\ServiceProvider;

use Illuminate\Support\Facades\Gate;

use Spatie\Health\Facades\Health;
use Spatie\Health\Checks\Checks\OptimizedAppCheck;
use Spatie\Health\Checks\Checks\DebugModeCheck;
use Spatie\Health\Checks\Checks\EnvironmentCheck;
use Spatie\Health\Checks\Checks\DatabaseCheck;
use Spatie\Health\Checks\Checks\UsedDiskSpaceCheck;
use Spatie\SecurityAdvisoriesHealthCheck\SecurityAdvisoriesCheck;
use Spatie\Health\Checks\Checks\ScheduleCheck;
use Spatie\CpuLoadHealthCheck\CpuLoadCheck;
use Spatie\Health\Checks\Checks\CacheCheck;

use TomatoPHP\FilamentInvoices\Facades\FilamentInvoices;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFor;
use TomatoPHP\FilamentInvoices\Services\Contracts\InvoiceFrom;




use App\Filament\Widgets\ProjectStats;
use Filament\PluginServiceProvider;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;







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
         Health::checks([
                OptimizedAppCheck::new(),
                DebugModeCheck::new(),
                EnvironmentCheck::new(),
                DatabaseCheck::new(),
                UsedDiskSpaceCheck::new(),
                SecurityAdvisoriesCheck::new(),
                ScheduleCheck::new(),
                CpuLoadCheck::new()
                ->failWhenLoadIsHigherInTheLast5Minutes(2.0)
                ->failWhenLoadIsHigherInTheLast15Minutes(1.5),
                CacheCheck::new(),
            ]);

            FilamentInvoices::registerFor([
                InvoiceFor::make(Client::class)
                    ->label('Account')
            ]);
            FilamentInvoices::registerFrom([
                InvoiceFrom::make(User::class)
                    ->label('Company')
            ]);


    

    }






}