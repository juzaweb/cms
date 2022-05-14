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

use Juzaweb\CMS\Contracts\ThemeLoaderContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Theme\Theme;
use Juzaweb\CMS\Support\LocalThemeRepository;
use Juzaweb\Frontend\Actions\FrontendAction;
use Juzaweb\Frontend\Actions\ThemeAction;

class FrontendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'cms');
        $this->app->register(RouteServiceProvider::class);

        $this->mergeConfigFrom(__DIR__.'/../config/theme.php', 'theme');
    }
}
