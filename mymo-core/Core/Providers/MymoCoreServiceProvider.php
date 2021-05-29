<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:53 PM
 */

namespace Mymo\Core\Providers;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Mymo\Core\Helpers\HookAction;
use Mymo\FileManager\Providers\FilemanagerServiceProvider;
use Mymo\Module\LaravelModulesServiceProvider;
use Mymo\Performance\Providers\MymoPerformanceServiceProvider;
use Mymo\Theme\Providers\ThemeServiceProvider;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class MymoCoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootMiddlewares();
        $this->loadMigrationsFrom(core_path('database/migrations'));
        $this->loadFactoriesFrom(core_path('database/factories'));
        $this->loadViewsFrom(core_path('resources/views'), 'mymo_core');
        $this->loadTranslationsFrom(core_path('resources/lang'), 'mymo_core');

        Validator::extend('recaptcha', 'Mymo\Core\Validators\Recaptcha@validate');
        Schema::defaultStringLength(150);
    }

    public function register()
    {
        $this->registerProviders();
        $this->registerSingleton();
    }

    protected function bootMigrations()
    {
        $mainPath = base_path('mymo-core/Core/database/migrations');
        $directories = glob($mainPath . '/*' , GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', \Mymo\Core\Http\Middleware\Admin::class);
    }

    protected function registerProviders()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->register(RouteServiceProvider::class);
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(MymoPerformanceServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(FilemanagerServiceProvider::class);
        $this->app->register(TranslatableServiceProvider::class);
        $this->app->register(LaravelModulesServiceProvider::class);
    }

    protected function registerSingleton()
    {
        $this->app->singleton('mymo.hook', function () {
            return new HookAction();
        });
    }
}