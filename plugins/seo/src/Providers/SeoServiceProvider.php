<?php

namespace Juzaweb\Seo\Providers;

use Juzaweb\Support\ServiceProvider;

class SeoServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'jseo');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'jseo');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
    }

    public function register()
    {
        $this->app->register(EventServiceProvider::class);
    }
}
