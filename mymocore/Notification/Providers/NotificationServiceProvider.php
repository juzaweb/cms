<?php

namespace Mymo\Notification\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Mymo\Core\Facades\HookAction;
use Mymo\Notification\Notification;
use Mymo\Notification\Notifications\DatabaseNotification;
use Mymo\Notification\Notifications\EmailNotification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/notification.php' => config_path('notification.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'mymo_notification');
        $this->bootCommands();
        HookAction::loadActionForm(__DIR__ . '/../actions');
        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/notification.php',
            'notification'
        );
        $this->registerCommands();
        $this->app->register(RouteServiceProvider::class);
    }

    protected function bootCommands()
    {
        $schedule = $this->app->make(Schedule::class);
        $schedule->command('notify:send')->everyMinute();
    }

    protected function registerCommands()
    {
        $this->commands([
            \Mymo\Notification\Commands\SendNotify::class,
        ]);
    }
}
