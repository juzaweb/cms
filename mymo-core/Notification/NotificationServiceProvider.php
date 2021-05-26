<?php

namespace Mymo\Notification;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Mymo\Notification\Notifications\BroadcastNotification;
use Mymo\Notification\Notifications\DatabaseNotification;
use Mymo\Notification\Notifications\EmailNotification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/notification.php' => config_path('notification.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');

        $schedule = $this->app->make(Schedule::class);
        $schedule->command('uploads:clear')
            ->everyMinute();

        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
        Notification::register('broadcaster', BroadcastNotification::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/notification.php',
            'notification'
        );

        $this->commands([
            \Mymo\Notification\Commands\SendNotify::class,
        ]);
    }
}
