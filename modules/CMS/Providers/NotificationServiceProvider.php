<?php

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Console\Commands\SendNotifyCommand;
use Juzaweb\CMS\Support\Notification;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\CMS\Support\Notifications\DatabaseNotification;
use Juzaweb\CMS\Support\Notifications\EmailNotification;

class NotificationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
    }

    public function register()
    {
        $this->commands(
            [
                SendNotifyCommand::class,
            ]
        );
    }
}
