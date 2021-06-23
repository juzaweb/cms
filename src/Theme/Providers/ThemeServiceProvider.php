<?php

namespace Mymo\Theme\Providers;

use Illuminate\Support\ServiceProvider;
use Mymo\Theme\Console\ThemeGeneratorCommand;
use Mymo\Theme\Console\ThemeListCommand;
use Mymo\Theme\Contracts\ThemeContract;
use Mymo\Theme\Managers\Theme;

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
        $this->registerTheme();
        $this->consoleCommand();
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
     * Add Commands.
     *
     * @return void
     */
    public function consoleCommand()
    {
        $this->commands([
            ThemeGeneratorCommand::class,
            ThemeListCommand::class
        ]);
    }
}
