<?php

namespace Juzaweb\Backend\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Juzaweb\Backend\Actions\EnqueueStyleAction;
use Juzaweb\Backend\Actions\FrontendAction;
use Juzaweb\Backend\Actions\MenuAction;
use Juzaweb\Backend\Actions\PermissionAction;
use Juzaweb\Backend\Actions\SocialLoginAction;
use Juzaweb\Backend\Actions\ThemeAction;
use Juzaweb\Backend\Actions\ToolAction;
use Juzaweb\Backend\Commands\FindTransCommand;
use Juzaweb\Backend\Commands\PermissionGenerateCommand;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Observers\CommentObserver;
use Juzaweb\CMS\Http\Middleware\Admin;
use Juzaweb\CMS\Support\Html\Field;
use Juzaweb\CMS\Support\Macros\RouterMacros;
use Juzaweb\CMS\Support\ServiceProvider;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Observers\TaxonomyObserver;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Observers\MenuObserver;
use Juzaweb\Backend\Observers\PostObserver;
use Juzaweb\CMS\Facades\ActionRegister;

class BackendServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->bootMiddlewares();
        $this->bootPublishes();

        Taxonomy::observe(TaxonomyObserver::class);
        Post::observe(PostObserver::class);
        Menu::observe(MenuObserver::class);
        Comment::observe(CommentObserver::class);
    
        ActionRegister::register(
            [
                MenuAction::class,
                EnqueueStyleAction::class,
                ThemeAction::class,
                FrontendAction::class,
                PermissionAction::class,
                SocialLoginAction::class,
                //ToolAction::class
            ]
        );
    
        $this->commands(
            [
                PermissionGenerateCommand::class,
                FindTransCommand::class,
            ]
        );
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(AuthServiceProvider::class);
        $this->registerRouteMacros();
        $this->app->booting(
            function () {
                $loader = AliasLoader::getInstance();
                $loader->alias('Field', Field::class);
            }
        );
    }

    protected function bootMiddlewares()
    {
        /**
         * @var \Illuminate\Routing\Router $router
         */
        $router = $this->app['router'];
        $router->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cms');
        
        $this->publishes(
            [
                __DIR__ . '/../resources/views' => resource_path('views/vendor/juzaweb'),
            ],
            'cms_views'
        );
        
        $this->publishes(
            [
                __DIR__ . '/../resources/lang' => resource_path('lang/vendor/juzaweb'),
            ],
            'cms_lang'
        );

        $this->publishes(
            [
                __DIR__ . '/../resources/assets' => public_path('jw-styles/juzaweb'),
            ],
            'cms_assets'
        );
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}
