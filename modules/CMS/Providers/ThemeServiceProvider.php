<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Contracts\ThemeLoaderContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Theme\Theme;
use Juzaweb\CMS\Support\LocalThemeRepository;
use Juzaweb\Frontend\Actions\FrontendAction;
use Juzaweb\Frontend\Actions\ThemeAction;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(
            [
                ThemeAction::class,
                FrontendAction::class,
            ]
        );
    }

    public function register()
    {
        $this->app->singleton(
            ThemeLoaderContract::class,
            function ($app) {
                return new Theme($app, $app['view']->getFinder(), $app['config'], $app['translator']);
            }
        );

        $this->app->singleton(
            LocalThemeRepositoryContract::class,
            function ($app) {
                $path = config('juzaweb.theme.path');
                return new LocalThemeRepository($app, $path);
            }
        );

        $this->app->alias(LocalThemeRepositoryContract::class, 'themes');
    }
}