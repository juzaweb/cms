<?php

namespace Juzaweb\AdsManager\Providers;

use Juzaweb\AdsManager\AdsManagerAction;
use Juzaweb\Facades\ActionRegister;
use Juzaweb\Support\ServiceProvider;

class AdsManagerServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(AdsManagerAction::class);
        
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juad');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'juad');
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
