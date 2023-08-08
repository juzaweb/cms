<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands\Plugin\Translation;

use Illuminate\Console\Command;
use Juzaweb\CMS\Contracts\TranslationManager;
use Symfony\Component\Console\Input\InputArgument;

class ExportTranslationCommand extends Command
{
    protected $name = 'plugin:export-translation';

    public function handle(): int
    {
        $exporter = app(TranslationManager::class)
            ->export('plugin', $this->argument('plugin'));

        if ($language = $this->argument('language')) {
            $exporter->setLanguage($language);
        }

        $exporter->run();

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['plugin', InputArgument::REQUIRED, 'The name of plugin will be import.'],
            ['language', InputArgument::OPTIONAL, 'The name of plugin will be import.'],
        ];
    }
}
