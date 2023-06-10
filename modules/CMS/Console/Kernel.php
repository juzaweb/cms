<?php

namespace Juzaweb\CMS\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Juzaweb\CMS\Console\Commands\ClearCacheExpiredCommand;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('email:send')->everyMinute();
        $schedule->command('notify:send')->everyMinute();
        $schedule->command(ClearCacheExpiredCommand::class)->hourlyAt('2');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        // $this->load(__DIR__.'/Commands');

        // require base_path('routes/console.php');
    }
}
