<?php
/**
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\GlobalDataContract;
use Juzaweb\Backend\Contracts\HookActionContract;
use Juzaweb\Contracts\XssCleanerContract;
use Juzaweb\Support\GlobalData;
use Juzaweb\Backend\Support\HookAction;
use Juzaweb\Support\Validators\ModelExists;
use Juzaweb\Support\Validators\ModelUnique;
use Juzaweb\Support\XssCleaner;
use Juzaweb\Support\Validators\ReCaptcha;
use Juzaweb\Support\Validators\DomainValidator;
use Illuminate\Validation\Rule;

class CoreServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();

        Validator::extend('recaptcha', [ReCaptcha::class, 'validate']);
        Validator::extend('domain', [DomainValidator::class, 'validate']);
    
        Rule::macro(
            'modelExists',
            function (
                string $modelClass,
                string $modelAttribute = 'id',
                callable $callback = null
            ) {
                return new ModelExists($modelClass, $modelAttribute, $callback);
            }
        );
    
        Rule::macro(
            'modelUnique',
            function (
                string $modelClass,
                string $modelAttribute = 'id',
                callable $callback = null
            ) {
                return new ModelUnique($modelClass, $modelAttribute, $callback);
            }
        );
    
        Schema::defaultStringLength(150);

        /*$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('juzacms:update')->everyMinute();
        });*/
    }

    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);

            if (config('app.debug')) {
                $this->app->register(DebugbarServiceProvider::class);
            }
        }

        $this->registerSingleton();
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/juzaweb.php',
            'juzaweb'
        );

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/locales.php',
            'locales'
        );
    }

    protected function bootMigrations()
    {
        $mainPath = JW_PACKAGE_PATH . '/database/migrations';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function bootPublishes()
    {
        $this->publishes(
            [
                JW_PACKAGE_PATH . '/config/juzaweb.php' => base_path('config/juzaweb.php'),
                JW_PACKAGE_PATH . '/config/locales.php' => base_path('config/locales.php'),
            ],
            'juzaweb_config'
        );
    }

    protected function registerSingleton()
    {
        $this->app->singleton(HookActionContract::class, function () {
            return new HookAction();
        });

        $this->app->singleton(GlobalDataContract::class, function () {
            return new GlobalData();
        });

        $this->app->singleton(XssCleanerContract::class, function () {
            return new XssCleaner();
        });
    }
}
