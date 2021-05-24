<?php

namespace App\Core\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        //
    ];
    
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:send')->everyMinute();
        $schedule->command('notify:send')->everyFiveMinutes();
    }
    
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require app_path('Core/routes/console.php');
    }
}
