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

use Juzaweb\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/../..';

    public function boot()
    {
        $this->loadMigrationsFrom($this->basePath . '/database/migrations');
    }

    public function register()
    {
        $this->app->register(PackageServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }
}
