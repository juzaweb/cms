<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Providers;

use Illuminate\Console\Scheduling\Schedule;
use Juzaweb\CMS\Console\Commands\ClearCacheCommand;
use Juzaweb\CMS\Console\Commands\InstallCommand;
use Juzaweb\CMS\Console\Commands\PluginAutoloadCommand;
use Juzaweb\CMS\Console\Commands\SendMailCommand;
use Juzaweb\CMS\Console\Commands\UpdateCommand;
use Juzaweb\CMS\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    protected array $commands = [
        InstallCommand::class,
        UpdateCommand::class,
        SendMailCommand::class,
        ClearCacheCommand::class,
        PluginAutoloadCommand::class
    ];

    public function boot()
    {
        $this->app->booted(
            function () {
                $schedule = $this->app->make(Schedule::class);
                if (get_config('jw_auto_ping')) {
                    $schedule->command('juzacms:auto-submit')->daily();
                }
            }
        );
    }

    public function register()
    {
        $this->commands($this->commands);
    }

    /**
     * @return array
     */
    public function provides(): array
    {
        return $this->commands;
    }
}
