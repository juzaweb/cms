<?php

namespace Juzaweb\Permission\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Permission\PermissionAction;
use Juzaweb\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register([
            PermissionAction::class
        ]);
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }
}
