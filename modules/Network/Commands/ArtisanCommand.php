<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Commands;

use Illuminate\Console\Command;

class ArtisanCommand extends Command
{
    protected $signature = 'network:run {cmd} {site} {options?}';

    protected $description = 'Run artisan commands subsite.';

    public function handle(): int
    {
        $command = $this->argument('cmd');

        $options = $this->argument('options');

        $options = $options ? json_decode($options, true) : [];

        $this->call($command, $options);

        return self::SUCCESS;
    }
}
