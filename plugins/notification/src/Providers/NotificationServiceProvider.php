<?php

namespace Juzaweb\Notification\Providers;

use Juzaweb\Facades\ActionRegister;
use Juzaweb\Notification\NotificationAction;
use Juzaweb\Support\ServiceProvider;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        ActionRegister::register(NotificationAction::class);
        
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'juno');
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
    }
}
