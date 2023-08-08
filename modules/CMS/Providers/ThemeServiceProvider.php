<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\Facades\Lang;
use Juzaweb\CMS\Contracts\Theme\ThemeRender as ThemeRenderContract;
use Juzaweb\CMS\Contracts\ThemeLoaderContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Facades\ActionRegister;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Theme\Theme;
use Juzaweb\CMS\Support\LocalThemeRepository;
use Juzaweb\CMS\Support\Theme\ThemeRender;
use Juzaweb\Frontend\Actions\FrontendAction;
use Juzaweb\Frontend\Actions\ThemeAction;

class ThemeServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        if (config('juzaweb.frontend.enable')) {
            $this->registerTheme();
        }
    }

    public function register(): void
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

        $this->app->bind(ThemeRenderContract::class, ThemeRender::class);

        $this->app->alias(LocalThemeRepositoryContract::class, 'themes');
    }

    protected function registerTheme(): void
    {
        Lang::addJsonPath(ThemeLoader::getPath(jw_current_theme(), 'lang'));

        ActionRegister::register(
            [
                ThemeAction::class,
                FrontendAction::class,
            ]
        );
    }
}
