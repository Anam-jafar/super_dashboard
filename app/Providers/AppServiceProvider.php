<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;
use App\Services\InstituteService;
use App\Services\DistrictAccessService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

        // $this->app->singleton(InstituteService::class, function ($app) {
        //     return new InstituteService();
        // });

        // $this->app->singleton(DistrictAccessService::class, function ($app) {
        //     return new DistrictAccessService();
        // });


    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
