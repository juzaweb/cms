<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes(
            [
                __DIR__ . '/../../config/email.php' => base_path('config/email.php'),
            ],
            'jw_email_config'
        );

        $this->app->booted(
            function () {
                $schedule = $this->app->make(Schedule::class);
                $schedule->command('email:send')->everyMinute();
            }
        );
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../../config/email.php', 'email');
    }
}
