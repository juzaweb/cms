<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Contracts\ThemeContract;
use Juzaweb\CMS\Contracts\ThemeInterface;
use Juzaweb\CMS\Support\Theme\Theme;
use Juzaweb\CMS\Support\ThemeFileRepository;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/theme.php', 'theme');

        $this->app->singleton(
            ThemeContract::class,
            function ($app) {
                return new Theme($app, $app['view']->getFinder(), $app['config'], $app['translator']);
            }
        );

        $this->app->singleton(
            ThemeInterface::class,
            function ($app) {
                $path = config('juzaweb.theme.path');
                return new ThemeFileRepository($app, $path);
            }
        );

        $this->app->alias(ThemeInterface::class, 'themes');
    }
}
