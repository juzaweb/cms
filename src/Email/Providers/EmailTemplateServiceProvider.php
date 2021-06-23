<?php

namespace Mymo\Email\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Mymo\Email\Commands\SendMailCommand;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('email:send')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->commands([
            SendMailCommand::class,
        ]);
    }
}
