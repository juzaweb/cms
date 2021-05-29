<?php

namespace Mymo\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Core\Helpers\IP2Location;

class IP2LocationServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind('ip2location', IP2Location::class);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
