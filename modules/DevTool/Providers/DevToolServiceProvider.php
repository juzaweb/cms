<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Providers;

use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Juzaweb\CMS\Providers\TelescopeServiceProvider;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Stub;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class DevToolServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->environment('local')) {
            if (config('app.debug')) {
                if (class_exists(TelescopeApplicationServiceProvider::class)
                    && class_exists(TelescopeServiceProvider::class)
                ) {
                    $this->app->register(TelescopeServiceProvider::class);
                }
            }

            Builder::macro(
                'toRawSql',
                function () {
                    return array_reduce(
                        $this->getBindings(),
                        function ($sql, $binding) {
                            return preg_replace(
                                '/\?/',
                                is_numeric($binding) ? $binding : "'".$binding."'",
                                $sql,
                                1
                            );
                        },
                        $this->toSql()
                    );
                }
            );

            EloquentBuilder::macro(
                'toRawSql',
                function () {
                    return array_reduce(
                        $this->getBindings(),
                        function ($sql, $binding) {
                            return preg_replace(
                                '/\?/',
                                is_numeric($binding) ? $binding : "'".$binding."'",
                                $sql,
                                1
                            );
                        },
                        $this->toSql()
                    );
                }
            );
        }
    }

    public function register()
    {
        $this->setupStubPath();

        $this->app->register(ConsoleServiceProvider::class);
    }

    /**
     * Setup stub path.
     */
    public function setupStubPath(): void
    {
        Stub::setBasePath(__DIR__ . '/../stubs/plugin');
    }
}
