<?php

namespace Juzaweb\CMS\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\RateLimiter;
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
use Juzaweb\CMS\Contracts\Field;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\GoogleTranslate as GoogleTranslateContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Contracts\JuzawebApiContract;
use Juzaweb\CMS\Contracts\JWQueryContract;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
use Juzaweb\CMS\Contracts\MacroableModelContract;
use Juzaweb\CMS\Contracts\Media\Media as MediaContract;
use Juzaweb\CMS\Contracts\OverwriteConfigContract;
use Juzaweb\CMS\Contracts\PostImporterContract;
use Juzaweb\CMS\Contracts\PostManagerContract;
use Juzaweb\CMS\Contracts\ShortCode as ShortCodeContract;
use Juzaweb\CMS\Contracts\ShortCodeCompiler as ShortCodeCompilerContract;
use Juzaweb\CMS\Contracts\StorageDataContract;
use Juzaweb\CMS\Contracts\TableGroupContract;
use Juzaweb\CMS\Contracts\ThemeConfigContract;
use Juzaweb\CMS\Contracts\TranslationFinder as TranslationFinderContract;
use Juzaweb\CMS\Contracts\TranslationManager as TranslationManagerContract;
use Juzaweb\CMS\Contracts\XssCleanerContract;
use Juzaweb\CMS\Extension\Custom;
use Juzaweb\CMS\Facades\OverwriteConfig;
use Juzaweb\CMS\Support\ActionRegister;
use Juzaweb\CMS\Support\CacheGroup;
use Juzaweb\CMS\Support\Config as DbConfig;
use Juzaweb\CMS\Support\DatabaseTableGroup;
use Juzaweb\CMS\Support\GlobalData;
use Juzaweb\CMS\Support\GoogleTranslate;
use Juzaweb\CMS\Support\HookAction;
use Juzaweb\CMS\Support\Html\Field as HtmlField;
use Juzaweb\CMS\Support\Imports\PostImporter;
use Juzaweb\CMS\Support\JuzawebApi;
use Juzaweb\CMS\Support\JWQuery;
use Juzaweb\CMS\Support\MacroableModel;
use Juzaweb\CMS\Support\Manager\BackendMessageManager;
use Juzaweb\CMS\Support\Manager\PostManager;
use Juzaweb\CMS\Support\Manager\TranslationManager;
use Juzaweb\CMS\Support\Media\Media;
use Juzaweb\CMS\Support\ShortCode\Compilers\ShortCodeCompiler;
use Juzaweb\CMS\Support\ShortCode\ShortCode;
use Juzaweb\CMS\Support\StorageData;
use Juzaweb\CMS\Support\Theme\ThemeConfig;
use Juzaweb\CMS\Support\Translations\TranslationFinder;
use Juzaweb\CMS\Support\Validators\ModelExists;
use Juzaweb\CMS\Support\Validators\ModelUnique;
use Juzaweb\CMS\Support\XssCleaner;
use Juzaweb\DevTool\Providers\DevToolServiceProvider;
use Juzaweb\Frontend\Providers\FrontendServiceProvider;
use Juzaweb\Multilang\Providers\MultilangServiceProvider;
use Juzaweb\Network\Providers\NetworkServiceProvider;
use Juzaweb\Translation\Providers\TranslationServiceProvider;
use Laravel\Passport\Passport;
use TwigBridge\Facade\Twig;

class CmsServiceProvider extends ServiceProvider
{
    protected string $basePath = __DIR__.'/..';

    public function boot()
    {
        $this->bootMigrations();
        $this->bootPublishes();
        $this->configureRateLimiting();

        Validator::extend(
            'recaptcha',
            '\Juzaweb\CMS\Support\Validators\ReCaptchaValidator@validate'
        );

        Validator::extend(
            'domain',
            '\Juzaweb\CMS\Support\Validators\DomainValidator@validate'
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

        // Prevent lazy loading in local environment
        //Model::preventLazyLoading(!$this->app->isProduction());

        Schema::defaultStringLength(150);

        Twig::addExtension(new Custom());

        Paginator::useBootstrapFive();

        OverwriteConfig::init();

        /*$this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);
            $schedule->command('juzacms:update')->everyMinute();
        });*/
    }

    public function register(): void
    {
        $this->registerSingleton();
        $this->registerConfigs();
        $this->registerProviders();
        Passport::ignoreMigrations();
    }

    protected function registerConfigs()
    {
        $this->mergeConfigFrom(
            $this->basePath.'/config/juzaweb.php',
            'juzaweb'
        );

        $this->mergeConfigFrom(
            $this->basePath.'/config/locales.php',
            'locales'
        );

        $this->mergeConfigFrom(
            $this->basePath.'/config/countries.php',
            'countries'
        );

        $this->mergeConfigFrom(
            $this->basePath.'/config/installer.php',
            'installer'
        );

        $this->mergeConfigFrom(
            $this->basePath.'/config/network.php',
            'network'
        );
    }

    protected function bootMigrations()
    {
        $mainPath = $this->basePath.'/Database/migrations';
        $directories = glob($mainPath.'/*', GLOB_ONLYDIR);
        $paths = array_merge([$mainPath], $directories);
        $this->loadMigrationsFrom($paths);
    }

    protected function bootPublishes()
    {
        $this->publishes(
            [
                $this->basePath.'/config/juzaweb.php' => base_path('config/juzaweb.php'),
                $this->basePath.'/config/network.php' => base_path('config/network.php'),
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
                    $app['request'],
                    $app['translator']
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

        $this->app->singleton(
            Field::class,
            function ($app) {
                return new HtmlField();
            }
        );

        $this->app->singleton(
            ShortCodeCompilerContract::class,
            function ($app) {
                return new ShortCodeCompiler();
            }
        );

        $this->app->singleton(
            ShortCodeContract::class,
            function ($app) {
                return new ShortCode($app[ShortCodeCompilerContract::class]);
            }
        );

        $this->app->singleton(MediaContract::class, Media::class);

        $this->app->singleton(
            TranslationFinderContract::class,
            function ($app) {
                return new TranslationFinder();
            }
        );

        $this->app->singleton(
            TranslationManagerContract::class,
            function ($app) {
                return new TranslationManager(
                    $app[LocalPluginRepositoryContract::class],
                    $app[LocalThemeRepositoryContract::class],
                    $app[TranslationFinderContract::class],
                    $app[GoogleTranslateContract::class]
                );
            }
        );

        $this->app->bind(
            GoogleTranslateContract::class,
            fn ($app) => new GoogleTranslate($app[\Illuminate\Contracts\Filesystem\Factory::class])
        );
    }

    protected function registerProviders()
    {
        $this->app->register(RepositoryServiceProvider::class);
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
        //$this->app->register(MultilangServiceProvider::class);
        $this->app->register(BackendServiceProvider::class);
        $this->app->register(FrontendServiceProvider::class);
        $this->app->register(ShortCodeServiceProvider::class);

        if (config('juzaweb.translation.enable')) {
            $this->app->register(TranslationServiceProvider::class);
        }

        if (config('juzaweb.api.enable')) {
            $this->app->register(APIServiceProvider::class);
        }
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for(
            'api',
            function (Request $request) {
                return Limit::perMinute(120)
                    ->by($request->user()?->id ?: get_client_ip());
            }
        );
    }
}
