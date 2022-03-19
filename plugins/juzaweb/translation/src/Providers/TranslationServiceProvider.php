<?php

namespace Juzaweb\Translation\Providers;

use Juzaweb\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(
            __DIR__ . '/../resources/views',
            'jutr'
        );
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
