<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Providers;

use Illuminate\Support\ServiceProvider;
use Juzaweb\CMS\Support\BladeMinifyCompiler;

class PerformanceServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //
    }

    public function register()
    {
        if (config('juzaweb.performance.minify_views')) {
            $this->registerBladeCompiler();
        }
    }

    protected function registerBladeCompiler()
    {
        $this->app->singleton(
            'blade.compiler',
            function ($app) {
                return new BladeMinifyCompiler($app['files'], $app['config']['view.compiled']);
            }
        );
    }
}
