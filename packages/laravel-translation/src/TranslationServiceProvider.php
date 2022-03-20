<?php

namespace Spatie\TranslationLoader;

use Illuminate\Support\Str;
use Illuminate\Translation\TranslationServiceProvider as IlluminateTranslationServiceProvider;
use Juzaweb\Support\Installer;

class TranslationServiceProvider extends IlluminateTranslationServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        parent::register();

        $this->mergeConfigFrom(__DIR__.'/../config/translation-loader.php', 'translation-loader');
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole() && ! Str::contains($this->app->version(), 'Lumen')) {
            $this->publishes([
                __DIR__.'/../config/translation-loader.php' => config_path('translation-loader.php'),
            ], 'config');
        }
    }

    /**
     * Register the translation line loader. This method registers a
     * `TranslationLoaderManager` instead of a simple `FileLoader` as the
     * applications `translation.loader` instance.
     */
    protected function registerLoader()
    {
        if (Installer::alreadyInstalled()) {
            $this->app->singleton('translation.loader', function ($app) {
                $class = config('translation-loader.translation_manager');

                return new $class($app['files'], $app['path.lang']);
            });
        } else {
            parent::registerLoader();
        }
    }
}
