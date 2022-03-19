<?php

namespace Juzaweb\Notification\Providers;

use Juzaweb\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juno');
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
    }
}
