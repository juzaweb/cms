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

class GoogleTranslateCommand extends Command
{
    protected $name = 'plugin:translate';

    public function handle(): int
    {
        $plugin = $this->argument('plugin');
        $source = $this->argument('source');
        $target = $this->argument('target');

        $translate = app(TranslationManager::class)->translate($source, $target, 'plugin', $plugin);

        $this->info("Translate success {$translate['total']} language text.");

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of plugin will be import.'],
            ['source', InputArgument::REQUIRED, 'Source translate language.'],
            ['target', InputArgument::REQUIRED, 'Target translate language.'],
        ];
    }
}
