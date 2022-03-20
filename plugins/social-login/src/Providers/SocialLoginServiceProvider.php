<?php

namespace Juzaweb\SocialLogin\Providers;

use Juzaweb\Support\ServiceProvider;

class SocialLoginServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/..';

    public function boot()
    {
        $this->loadViewsFrom($this->basePath . '/resources/views', 'juso');
        $this->loadTranslationsFrom($this->basePath . '/resources/lang', 'juso');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
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
