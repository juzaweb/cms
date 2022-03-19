<?php

namespace Juzaweb\SocialLogin\Providers;

use Juzaweb\Support\ServiceProvider;
use Juzaweb\Multisite\Observers\SiteObserver;
use Juzaweb\Multisite\Scopes\SiteScope;

class SocialLoginServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/..';

    public function boot()
    {
        $this->loadViewsFrom($this->basePath . '/resources/views', 'juso');
        $this->loadTranslationsFrom($this->basePath . '/resources/lang', 'juso');
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $classes = [
            'Juzaweb\SocialLogin\Models\SocialToken'
        ];

        foreach ($classes as $class) {
            $class::observe(SiteObserver::class);
            $class::addGlobalScope(new SiteScope());
        }
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
