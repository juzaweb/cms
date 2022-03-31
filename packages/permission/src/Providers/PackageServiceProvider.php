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

use Juzaweb\Permission\Support\PermissionRegistrar;
use Spatie\Permission\PermissionServiceProvider as ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
    public function boot(\Spatie\Permission\PermissionRegistrar $permissionLoader)
    {
        $this->offerPublishing();

        $this->registerMacroHelpers();

        $this->registerCommands();

        $this->registerModelBindings();

        $permissionLoader = app(PermissionRegistrar::class);

        if ($this->app->config['permission.register_permission_check_method']) {
            $permissionLoader->clearClassPermissions();
            $permissionLoader->registerPermissions();
        }

        $this->app->singleton(PermissionRegistrar::class, function ($app) use ($permissionLoader) {
            return $permissionLoader;
        });
    }
}
