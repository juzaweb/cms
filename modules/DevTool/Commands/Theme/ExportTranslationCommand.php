<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\DevTool\Commands\Theme;

use Illuminate\Console\Command;
use Juzaweb\CMS\Contracts\TranslationManager;
use Symfony\Component\Console\Input\InputArgument;

class ExportTranslationCommand extends Command
{
    protected $name = 'theme:export-translation';

    public function handle(): int
    {
        $exporter = app(TranslationManager::class)
            ->export('theme', $this->argument('theme'));

        if ($language = $this->argument('language')) {
            $exporter->setLanguage($language);
        }

        $exporter->run();

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['theme', InputArgument::REQUIRED, 'The name of theme will be export.'],
            ['language', InputArgument::OPTIONAL, 'The name of theme will be export.'],
        ];
    }
}
