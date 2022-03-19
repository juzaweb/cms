<?php

namespace Juzaweb\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\ActionRegistionContract;
use Juzaweb\Contracts\SiteRegistionContract;
use Juzaweb\Support\ActionRegistion;
use Juzaweb\Support\SiteRegistion;
use Juzaweb\Support\Theme\ThemeConfig;
use Juzaweb\Support\Config as DbConfig;
use Juzaweb\Contracts\ConfigContract;
use Juzaweb\Contracts\ThemeConfigContract;
use Juzaweb\Support\Installer;

class CmsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(
            SiteRegistionContract::class,
            function ($app) {
                return new SiteRegistion(
                    $app,
                    $app->make('config'),
                    $app['request']
                );
            }
        );

        $this->app->singleton(
            ActionRegistionContract::class,
            function ($app) {
                return new ActionRegistion($app);
            }
        );

        if (Installer::alreadyInstalled()) {
            $this->app->singleton(ConfigContract::class, function ($app) {
                return new DbConfig($app);
            });

            $this->app->singleton(ThemeConfigContract::class, function ($app) {
                return new ThemeConfig($app, jw_current_theme());
            });
        }

        $this->registerProviders();
    }

    protected function registerProviders()
    {
        $this->app->register(CoreServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(PerformanceServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(TwigServiceProvider::class);
        //$this->app->register(SwaggerServiceProvider::class);
    }
}
