<?php

namespace Juzaweb\Providers;

use Barryvdh\Debugbar\ServiceProvider as DebugbarServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Support\ServiceProvider;
use Juzaweb\Contracts\ActionRegisterContract;
use Juzaweb\Contracts\MacroableModelContract;
use Juzaweb\Support\ActionRegister;
use Juzaweb\Support\MacroableModel;
use Juzaweb\Support\Theme\ThemeConfig;
use Juzaweb\Support\Config as DbConfig;
use Juzaweb\Contracts\ConfigContract;
use Juzaweb\Contracts\ThemeConfigContract;
use Juzaweb\Contracts\GlobalDataContract;
use Juzaweb\Backend\Contracts\HookActionContract;
use Juzaweb\Contracts\XssCleanerContract;
use Juzaweb\Support\GlobalData;
use Juzaweb\Backend\Support\HookAction;
use Juzaweb\Support\XssCleaner;
use Juzaweb\Support\Validators\ModelExists;
use Juzaweb\Support\Validators\ModelUnique;
use Juzaweb\Support\Validators\ReCaptcha;
use Juzaweb\Support\Validators\DomainValidator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;

class CmsServiceProvider extends ServiceProvider
{
    protected $basePath = __DIR__ . '/../..';
    
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
        $this->registerSingleton();
        $this->registerConfigs();
        $this->registerProviders();
    }
    
    protected function registerConfigs()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
            
            if (config('app.debug')) {
                $this->app->register(DebugbarServiceProvider::class);
            }
        }
        
        $this->mergeConfigFrom(
            $this->basePath . '/config/juzaweb.php',
            'juzaweb'
        );
        
        $this->mergeConfigFrom(
            $this->basePath . '/config/locales.php',
            'locales'
        );
    }
    
    protected function bootMigrations()
    {
        $mainPath = $this->basePath . '/database/migrations';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }
    
    protected function bootPublishes()
    {
        $this->publishes(
            [
                $this->basePath . '/config/juzaweb.php' => base_path('config/juzaweb.php'),
                $this->basePath . '/config/locales.php' => base_path('config/locales.php'),
            ],
            'cms_config'
        );
    }
    
    protected function registerSingleton()
    {
        $this->app->singleton(
            MacroableModelContract::class,
            function () {
                return new MacroableModel();
            }
        );
        
        $this->app->singleton(
            ActionRegisterContract::class,
            function ($app) {
                return new ActionRegister($app);
            }
        );
    
        $this->app->singleton(
            ConfigContract::class,
            function ($app) {
                return new DbConfig($app);
            }
        );
    
        $this->app->singleton(
            ThemeConfigContract::class,
            function ($app) {
                return new ThemeConfig($app, jw_current_theme());
            }
        );
        
        $this->app->singleton(
            HookActionContract::class,
            function () {
                return new HookAction();
            }
        );
        
        $this->app->singleton(
            GlobalDataContract::class,
            function () {
                return new GlobalData();
            }
        );
        
        $this->app->singleton(
            XssCleanerContract::class,
            function () {
                return new XssCleaner();
            }
        );
    }

    protected function registerProviders()
    {
        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(PerformanceServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        //$this->app->register(SwaggerServiceProvider::class);
    }
}
