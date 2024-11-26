<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use koolreport\KoolReport;

class KoolReportServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(KoolReport::class, function ($app) {
            return new KoolReport();
        });
    }

    public function boot()
    {
        //
    }
}
