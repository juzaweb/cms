<?php

namespace Tadcms\System\Providers;

use Illuminate\Support\ServiceProvider;
use Tadcms\System\Helpers\BladeMinifyCompiler;

class BladeCompilerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('blade.compiler', function ($app) {
            return new BladeMinifyCompiler($app['files'], $app['config']['view.compiled']);
        });
    }
}
