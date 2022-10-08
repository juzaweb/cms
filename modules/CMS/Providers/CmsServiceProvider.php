<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rule;
use Juzaweb\API\Providers\APIServiceProvider;
use Juzaweb\Backend\Providers\BackendServiceProvider;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\Backend\Repositories\TaxonomyRepository;
use Juzaweb\CMS\Contracts\ActionRegisterContract;
use Juzaweb\CMS\Contracts\BackendMessageContract;
use Juzaweb\CMS\Contracts\CacheGroupContract;
use Juzaweb\CMS\Contracts\ConfigContract;
use Juzaweb\CMS\Contracts\EventyContract;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Contracts\JWQueryContract;
use Juzaweb\CMS\Contracts\MacroableModelContract;
use Juzaweb\CMS\Contracts\OverwriteConfigContract;
use Juzaweb\CMS\Contracts\PostImporterContract;
use Juzaweb\CMS\Contracts\PostManagerContract;
use Juzaweb\CMS\Contracts\StorageDataContract;
use Juzaweb\CMS\Contracts\TableGroupContract;
use Juzaweb\CMS\Contracts\ThemeConfigContract;
use Juzaweb\CMS\Contracts\XssCleanerContract;
use Juzaweb\CMS\Extension\Custom;
use Juzaweb\CMS\Facades\OverwriteConfig;
use Juzaweb\CMS\Support\ActionRegister;
use Juzaweb\CMS\Support\CacheGroup;
use Juzaweb\CMS\Support\Config as DbConfig;
use Juzaweb\CMS\Support\DatabaseTableGroup;
use Juzaweb\CMS\Support\GlobalData;
use Juzaweb\CMS\Support\HookAction;
use Juzaweb\CMS\Support\Imports\PostImporter;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Support\JWQuery;
use Juzaweb\CMS\Support\MacroableModel;
use Juzaweb\CMS\Support\Manager\BackendMessageManager;
use Juzaweb\CMS\Support\Manager\PostManager;
use Juzaweb\CMS\Support\StorageData;
use Juzaweb\CMS\Support\Theme\ThemeConfig;
use Juzaweb\CMS\Support\Validators\DomainValidator;
use Juzaweb\CMS\Support\Validators\ModelExists;
use Juzaweb\CMS\Support\Validators\ModelUnique;
use Juzaweb\CMS\Support\Validators\ReCaptchaValidator;
use Juzaweb\CMS\Support\XssCleaner;
use Juzaweb\DevTool\Providers\DevToolServiceProvider;
use Juzaweb\Frontend\Providers\FrontendServiceProvider;
use Juzaweb\Network\Providers\NetworkServiceProvider;
use Juzaweb\Translation\Providers\TranslationServiceProvider;
use Laravel\Passport\Passport;
use TwigBridge\Facade\Twig;

class CmsServiceProvider extends ServiceProvider
{
    protected string $basePath = __DIR__ . '/..';

    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();

        Validator::extend(
            'recaptcha',
            [ReCaptchaValidator::class, 'validate']
        );

        Validator::extend(
            'domain',
            [DomainValidator::class, 'validate']
        );

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

        Twig::addExtension(new Custom());

        Paginator::useBootstrapFive();

        OverwriteConfig::init();

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
        Passport::ignoreMigrations();
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(
            $this->basePath . '/config/juzaweb.php',
            'juzaweb'
        );

        $this->mergeConfigFrom(
            $this->basePath . '/config/locales.php',
            'locales'
        );

        $this->mergeConfigFrom(
            $this->basePath . '/config/countries.php',
            'countries'
        );

        $this->mergeConfigFrom(
            $this->basePath . '/config/installer.php',
            'installer'
        );

        $this->mergeConfigFrom(
            $this->basePath . '/config/network.php',
            'network'
        );
    }

    protected function bootMigrations()
    {
        $mainPath = $this->basePath . '/Database/migrations';
        $directories = glob($mainPath . '/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function bootPublishes()
    {
        $this->publishes(
            [
                $this->basePath . '/config/juzaweb.php' => base_path('config/juzaweb.php'),
                $this->basePath . '/config/network.php' => base_path('config/network.php'),
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
                return new DbConfig($app, $app['cache']);
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
            function ($app) {
                return new HookAction(
                    $app[EventyContract::class],
                    $app[GlobalDataContract::class]
                );
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

        $this->app->singleton(
            CacheGroupContract::class,
            function ($app) {
                return new CacheGroup($app['cache']);
            }
        );

        $this->app->singleton(
            OverwriteConfigContract::class,
            function ($app) {
                return new DbConfig\OverwriteConfig(
                    $app['config'],
                    $app[ConfigContract::class],
                    $app['request']
                );
            }
        );

        $this->app->singleton(
            StorageDataContract::class,
            function () {
                return new StorageData();
            }
        );

        $this->app->singleton(
            TableGroupContract::class,
            function ($app) {
                return new DatabaseTableGroup(
                    $app['migrator']
                );
            }
        );

        $this->app->singleton(
            BackendMessageContract::class,
            function ($app) {
                return new BackendMessageManager(
                    $app[ConfigContract::class]
                );
            }
        );

        $this->app->singleton(
            JuzawebApiContract::class,
            function ($app) {
                return new JuzawebApi(
                    $app[ConfigContract::class]
                );
            }
        );

        $this->app->singleton(
            JWQueryContract::class,
            function ($app) {
                return new JWQuery($app['db']);
            }
        );

        $this->app->singleton(
            PostManagerContract::class,
            function ($app) {
                return new PostManager(
                    $app[PostRepository::class]
                );
            }
        );

        $this->app->singleton(
            PostImporterContract::class,
            function ($app) {
                return new PostImporter(
                    $app[PostManagerContract::class],
                    $app[HookActionContract::class],
                    $app[TaxonomyRepository::class]
                );
            }
        );
    }

    protected function registerProviders()
    {
        if (config('network.enable')) {
            $this->app->register(NetworkServiceProvider::class);
        }

        $this->app->register(HookActionServiceProvider::class);
        $this->app->register(PermissionServiceProvider::class);
        $this->app->register(PerformanceServiceProvider::class);
        $this->app->register(EventServiceProvider::class);
        $this->app->register(PluginServiceProvider::class);
        $this->app->register(ConsoleServiceProvider::class);
        $this->app->register(NotificationServiceProvider::class);
        $this->app->register(DevToolServiceProvider::class);
        $this->app->register(ThemeServiceProvider::class);
        $this->app->register(BackendServiceProvider::class);
        $this->app->register(FrontendServiceProvider::class);

        if (config('juzaweb.translation.enable')) {
            $this->app->register(TranslationServiceProvider::class);
        }

        if (config('juzaweb.api.enable')) {
            $this->app->register(APIServiceProvider::class);
        }
    }
}
