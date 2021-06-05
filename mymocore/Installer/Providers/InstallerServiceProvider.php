<?php

namespace Tadcms\Installer\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Tadcms\Installer\Middleware\canInstall;
use Tadcms\Installer\Middleware\canUpdate;

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
        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');
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
        $router->middlewareGroup('update', [CanUpdate::class]);
        $this->loadViewsFrom(__DIR__ . '/../Views', 'installer');
    }

    /**
     * Publish config file for the installer.
     *
     * @return void
     */
    protected function publishFiles()
    {
        /*$this->publishes([
            __DIR__.'/../config/installer.php' => base_path('config/installer.php'),
        ], 'installer');*/

        $this->publishes([
            __DIR__.'/../assets' => public_path('tadcms/installer'),
        ], 'installer');

        $this->publishes([
            __DIR__.'/../Lang' => base_path('resources/lang'),
        ], 'installer');
    }
}
