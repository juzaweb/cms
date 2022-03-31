<?php

namespace Juzaweb\Permission\Providers;

use Juzaweb\Models\User;
use Juzaweb\Permission\Commands\PermissionGenerateCommand;
use Juzaweb\Permission\Support\PermissionRegistrar;
use Juzaweb\Facades\ActionRegister;
use Juzaweb\Permission\PermissionAction;
use Juzaweb\Support\ServiceProvider;

class PermissionServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/../..';
    
    public function boot()
    {
        ActionRegister::register([
            PermissionAction::class
        ]);
    
        $this->loadMigrationsFrom($this->basePath . '/database/migrations');
        $this->loadViewsFrom($this->basePath . '/src/resources/views', 'perm');
        $this->loadTranslationsFrom($this->basePath . '/src/resources/lang', 'perm');
    
        $this->commands(
            [
                PermissionGenerateCommand::class,
            ]
        );
    }

    public function register()
    {
        $this->app->register(AuthServiceProvider::class);
        $this->app->register(RouteServiceProvider::class);
    }
}
