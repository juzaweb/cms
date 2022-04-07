<?php

namespace Juzaweb\Multilang\Providers;

use Juzaweb\Multilang\Http\Middleware\Multilang;
use Juzaweb\CMS\Support\ServiceProvider;

class MultilangServiceProvider extends ServiceProvider
{
    public function boot()
    {
        /** @var \Illuminate\Routing\Router $router */
        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('theme', Multilang::class);
    }
}
