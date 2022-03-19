<?php

namespace Juzaweb\Permission\Providers;

use Juzaweb\Permission\PermissionAction;
use Juzaweb\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'perm');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'perm');

        $this->registerAction([
            PermissionAction::class
        ]);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
