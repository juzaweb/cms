<?php

namespace Juzaweb\Installer\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Http\Middleware\CanInstall;
use Juzaweb\Http\Middleware\Installed;

class InstallerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/installer.php',
            'installer'
        );
    }

    public function boot(Router $router)
    {
        $router->aliasMiddleware('install', CanInstall::class);
        $router->pushMiddlewareToGroup('web', Installed::class);
    }
}
