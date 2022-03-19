<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Notification\Providers;

use Juzaweb\Multisite\Observers\SiteObserver;
use Juzaweb\Multisite\Scopes\SiteScope;
use Juzaweb\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\Notification\Commands\SendNotify;
use Juzaweb\Notification\Notification;
use Juzaweb\Notification\Notifications\DatabaseNotification;
use Juzaweb\Notification\Notifications\EmailNotification;

class ConsoleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        //$schedule = $this->app->make(Schedule::class);
        //$schedule->command('notify:send')->everyMinute();

        Notification::register('database', DatabaseNotification::class);
        Notification::register('mail', EmailNotification::class);

        $classes = [
            'Juzaweb\Notification\Models\ManualNotification',
            'Juzaweb\Notification\Models\Notification',
        ];

        foreach ($classes as $class) {
            $class::observe(SiteObserver::class);
            $class::addGlobalScope(new SiteScope());
        }
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
        $this->commands([
            SendNotify::class,
        ]);
    }
}
