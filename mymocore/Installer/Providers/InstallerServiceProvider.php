<?php

namespace Mymo\Installer\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Mymo\Installer\Middleware\CanInstall;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->publishFiles();
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->mergeConfigFrom(
            __DIR__ . '/../config/installer.php',
            'installer'
        );
    }

    /**
     * Bootstrap the application events.
     *
     * @param \Illuminate\Routing\Router $router
     */
    public function boot(Router $router)
    {
        $router->middlewareGroup('install', [CanInstall::class]);
        //$router->middlewareGroup('update', [CanUpdate::class]);
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'installer');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'installer');
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        $this->publishes([
            __DIR__.'/../config/installer.php' => base_path('config/installer.php'),
        ], 'installer_config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('styles/installer'),
        ], 'installer_assets');

        $this->publishes([
            __DIR__.'/../resources/lang' => base_path('resources/lang'),
        ], 'installer_lang');
    }
}
