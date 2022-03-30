<?php

namespace Juzaweb\Permission\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Permission\PermissionAction;
use Juzaweb\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'perm');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'perm');
    
        ActionRegister::register([
            PermissionAction::class
        ]);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
