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

class ImportTranslationCommand extends Command
{
    protected $name = 'plugin:import-translation';

    public function handle(): int
    {
        $importer = app(TranslationManager::class)
            ->import(
                'plugin',
                $this->argument('plugin')
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
            ['plugin', InputArgument::REQUIRED, 'The name of plugin will be import.'],
        ];
    }
}
