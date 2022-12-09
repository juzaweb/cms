<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands\Plugin;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputArgument;

class ExportTranslationCommand extends Command
{
    protected $name = 'plugin:export-translation';

    public function handle(): int
    {
        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of plugin will be import.'],
        ];
    }
}
