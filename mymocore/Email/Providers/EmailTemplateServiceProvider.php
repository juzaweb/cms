<?php

namespace Mymo\Email\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\ServiceProvider;
use Mymo\Email\Commands\SendMailCommand;
use Mymo\Core\Facades\HookAction;

class EmailTemplateServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/email-template.php' => config_path('email-template.php'),
        ], 'mymo_email_config');

        $this->loadMigrationsFrom(__DIR__.'/../migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'emailtemplate');
        HookAction::loadActionForm(__DIR__ . '/../actions');
        
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

        $this->app->register(RouteServiceProvider::class);
    }
}
