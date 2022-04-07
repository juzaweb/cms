<?php

namespace Juzaweb\Crawler\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\Crawler\Commands\CrawContentCommand;
use Juzaweb\Crawler\Commands\CrawLinkCommand;
use Juzaweb\Crawler\Models\CrawTemplate;
use Juzaweb\CMS\Support\ServiceProvider;

class AutoloadServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->commands(
            [
                CrawLinkCommand::class,
                CrawContentCommand::class
            ]
        );

        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('crawler:content')->everyMinute();
            $schedule->command('crawler:link')->everyFiveMinutes();
        });
    }
}
