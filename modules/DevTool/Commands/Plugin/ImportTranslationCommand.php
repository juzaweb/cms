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
use Juzaweb\CMS\Contracts\TranslationManager;
use Symfony\Component\Console\Input\InputArgument;

class ImportTranslationCommand extends Command
{
    protected $name = 'plugin:import-translation';

    public function handle(): int
    {
        $plugin = $this->argument('plugin');

        $import = app(TranslationManager::class)->import('plugin', $plugin);

        $this->info("Import success {$import} language text.");

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of plugin will be import.'],
        ];
    }
}
