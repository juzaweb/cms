<?php

namespace Juzaweb\Backend\Commands;

use Juzaweb\CMS\Contracts\TranslationManager;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\DevTool\Commands\Plugin\Translation\ImportTranslationCommand as PluginImportTranslationCommand;

class ImportTranslationCommand extends TranslationCommand
{
    protected $signature = 'juza:import-translations';

    public function handle(): int
    {
        $import = app(TranslationManager::class)->import('cms')->run();
        $this->info("Imported {$import} rows from core");

        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $this->info("Import translations {$plugin->getName()} plugin");

            $this->call(
                PluginImportTranslationCommand::class,
                [
                    'plugin' => $plugin->getName()
                ]
            );
        }

        $themes = ThemeLoader::all();
        foreach ($themes as $theme) {
            $import = app(TranslationManager::class)
                ->import('theme', $theme->get('name'))
                ->run();

            $this->info("Imported {$import} from {$theme->get('name')}");
        }

        return static::SUCCESS;
    }
}
