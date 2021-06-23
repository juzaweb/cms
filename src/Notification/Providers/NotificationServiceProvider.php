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
        $this->bootCommands();
        HookAction::loadActionForm(__DIR__ . '/../actions');
        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
    }

    public function register()
    {
        $this->registerCommands();
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
