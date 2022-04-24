<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Frontend\Providers;

use Juzaweb\CMS\Contracts\ThemeContract;
use Juzaweb\CMS\Contracts\ThemeInterface;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Theme\Theme;
use Juzaweb\CMS\Support\ThemeFileRepository;

class FrontendServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
        $this->app->register(RouteServiceProvider::class);

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
