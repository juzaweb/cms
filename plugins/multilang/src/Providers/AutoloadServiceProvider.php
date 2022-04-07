<?php

namespace Juzaweb\Multilang\Providers;

use Juzaweb\CMS\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mlla');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'mlla');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
