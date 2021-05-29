<?php

namespace Mymo\FileManager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Class LaravelFilemanagerServiceProvider.
 */
class LaravelFilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/lang', 'filemanager');

        $this->publishes([
            __DIR__ . '/config/filemanager.php' => base_path('config/filemanager.php'),
        ], 'filemanager_config');

        $this->publishes([
            __DIR__.'/../public' => public_path('styles/filemanager'),
        ], 'filemanager_public');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/filemanager.php', 'filemanager-config');
    }
}
