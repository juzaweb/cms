<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Notification\Providers;

use Juzaweb\CMS\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\Notification\Commands\SendNotify;
use Juzaweb\CMS\Support\Notification;
use Juzaweb\CMS\Support\Notifications\DatabaseNotification;
use Juzaweb\CMS\Support\Notifications\EmailNotification;

class ConsoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $schedule = $this->app->make(Schedule::class);
        $schedule->command('notify:send')->everyMinute();

        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);
    }

    public function register()
    {
        $this->registerCommands();
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/notification.php',
            'notification'
        );
    }

    protected function registerCommands()
    {
        $this->commands(
            [
                SendNotify::class,
            ]
        );
    }
}
