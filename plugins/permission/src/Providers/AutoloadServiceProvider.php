<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Permission\Providers;

use Juzaweb\Models\User;
use Juzaweb\Permission\Commands\PermissionGenerateCommand;
use Juzaweb\Permission\Support\PermissionRegistrar;
use Juzaweb\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/../..';

    public function boot()
    {
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
        $this->app->register(PackageServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }
}
