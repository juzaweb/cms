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
use Juzaweb\Multisite\Observers\SiteObserver;
use Juzaweb\Multisite\Scopes\SiteScope;

class AutoloadServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/../..';

    public function boot()
    {
        $this->loadMigrationsFrom($this->basePath . '/database/migrations');

        $classes = [
            'Juzaweb\Permission\Models\Role',
        ];

        foreach ($classes as $class) {
            $class::observe(SiteObserver::class);
            $class::addGlobalScope(new SiteScope());
        }
    }

    public function register()
    {
        $this->app->register(PackageServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
    }
}
