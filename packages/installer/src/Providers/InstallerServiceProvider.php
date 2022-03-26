<?php

namespace Juzaweb\Installer\Providers;

use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/installer.php',
            'installer'
        );
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'installer');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'installer');
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
    }

    public function boot()
    {
        //Route::aliasMiddleware('install', CanInstall::class);
        //Route::pushMiddlewareToGroup('web', Installed::class);
    }
}
