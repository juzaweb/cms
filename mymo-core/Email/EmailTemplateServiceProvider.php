<?php

namespace Tadcms\EmailTemplate;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Tadcms\EmailTemplate\Commands\SendMailCommand;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/email-template.php' => config_path('email-template.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
    
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'emailtemplate');
        
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('email:send')->everyMinute();
        });
    }
    
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/email-template.php',
            'email-template'
        );

        $this->commands([
            SendMailCommand::class,
        ]);
    }
}
