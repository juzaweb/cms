<?php

namespace App\Theme\Providers;

use App;
use File;
use Illuminate\Support\ServiceProvider;
use App\Theme\Console\ThemeListCommand;
use App\Theme\Contracts\ThemeContract;
use App\Theme\Managers\Theme;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if (!File::exists(public_path('themes')) && !File::exists(config('theme.symlink_path')) && config('theme.symlink') && File::exists(config('theme.theme_path'))) {
            App::make('files')->link(config('theme.theme_path'), config('theme.symlink_path', public_path('themes')));
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->publishConfig();
        $this->registerTheme();
        $this->registerHelper();
        $this->consoleCommand();
        $this->registerMiddleware();
        $this->loadViewsFrom(__DIR__.'/../Views', 'themevel');
    }

    /**
     * Add Theme Types Middleware.
     *
     * @return void
     */
    public function registerMiddleware()
    {
        if (config('theme.types.enable')) {
            $themeTypes = config('theme.types.middleware');
            foreach ($themeTypes as $middleware => $themeName) {
                $this->app['router']->aliasMiddleware($middleware, '\App\Theme\Middleware\RouteMiddleware:'.$themeName);
            }
        }
    }

    /**
     * Register theme required components .
     *
     * @return void
     */
    public function registerTheme()
    {
        $this->app->singleton(ThemeContract::class, function ($app) {
            $theme = new Theme($app, $this->app['view']->getFinder(), $this->app['config'], $this->app['translator']);

            return $theme;
        });
    }

    /**
     * Register All Helpers.
     *
     * @return void
     */
    public function registerHelper()
    {
        foreach (glob(__DIR__.'/../Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }

    /**
     * Publish config file.
     *
     * @return void
     */
    public function publishConfig()
    {
        $configPath = realpath(__DIR__.'/../../config/theme.php');

        $this->publishes([
            $configPath => config_path('theme.php'),
        ]);

        $this->mergeConfigFrom($configPath, 'theme');
    }

    /**
     * Add Commands.
     *
     * @return void
     */
    public function consoleCommand()
    {
        $this->registerThemeGeneratorCommand();
        $this->registerThemeListCommand();
        // Assign commands.
        $this->commands(
            'theme.create',
            'theme.list'
        );
    }

    /**
     * Register generator command.
     *
     * @return void
     */
    public function registerThemeGeneratorCommand()
    {
        $this->app->singleton('theme.create', function ($app) {
            return new \App\Theme\Console\ThemeGeneratorCommand($app['config'], $app['files']);
        });
    }

    /**
     * Register theme list command.
     *
     * @return void
     */
    public function registerThemeListCommand()
    {
        $this->app->singleton('theme.list', ThemeListCommand::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
