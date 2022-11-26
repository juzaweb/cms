<?php

namespace Juzaweb\Backend\Commands;

use Juzaweb\CMS\Contracts\TranslationManager;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\ThemeLoader;

class ImportTranslationCommand extends TranslationCommand
{
    protected $signature = 'juza:import-translation';

    public function handle(): int
    {
        $import = app(TranslationManager::class)->import('cms');
        $this->info("Imported {$import} rows from core");

        $plugins = Plugin::all();
        foreach ($plugins as $plugin) {
            $import = app(TranslationManager::class)->import('plugin', $plugin->get('name'));

            $this->info("Imported {$import} rows from {$plugin->getName()} plugin");
        }

        $themes = ThemeLoader::all();
        foreach ($themes as $theme) {
            $import = app(TranslationManager::class)->import('plugin', $theme->get('name'));

            $this->info("Imported {$import} from {$theme->get('name')}");
        }

        return static::SUCCESS;
    }
}
