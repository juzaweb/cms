<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Providers;

use Juzaweb\CMS\Console\Commands\ClearCacheCommand;
use Juzaweb\CMS\Console\Commands\InstallCommand;
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
    ];

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
