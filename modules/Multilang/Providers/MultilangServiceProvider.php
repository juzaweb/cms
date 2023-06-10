<?php

namespace Juzaweb\Multilang\Providers;

use Juzaweb\Multilang\Http\Middleware\Multilang;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Multilang\MultilangAction;

class MultilangServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('theme', Multilang::class);

        $this->registerHookActions([MultilangAction::class]);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mlla');
    }
}
