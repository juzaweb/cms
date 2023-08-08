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

class ImportTranslationCommand extends Command
{
    protected $name = 'theme:import-translation';

    public function handle(): int
    {
        $importer = app(TranslationManager::class)
            ->import(
                'theme',
                $this->argument('theme')
            );

        $importer->progressCallback(
            function ($model) {
                $this->info("--> Import translation key {$model->key}");
            }
        );

        $total = $importer->run();

        $this->info("Import success {$total} language text.");

        return self::SUCCESS;
    }

    protected function getArguments(): array
    {
        return [
            ['theme', InputArgument::REQUIRED, 'The name of theme will be import.'],
        ];
    }
}
