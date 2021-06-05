<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 10:10 PM
 */

namespace Mymo\FileManager\Providers;

use Illuminate\Support\ServiceProvider;

class FilemanagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'filemanager');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'filemanager');

        $this->publishes([
            __DIR__ . '/../config/filemanager.php' => base_path('config/filemanager.php'),
        ], 'filemanager_config');

        $this->publishes([
            __DIR__.'/../resources/assets' => public_path('styles/filemanager'),
        ], 'filemanager_assets');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/filemanager.php', 'filemanager');
        $this->app->register(RouteServiceProvider::class);
    }
}
