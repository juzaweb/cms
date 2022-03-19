<?php

namespace Juzaweb\Backend\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Observers\CommentObserver;
use Juzaweb\Http\Middleware\Admin;
use Juzaweb\Support\Html\Field;
use Juzaweb\Support\Macros\RouterMacros;
use Juzaweb\Support\ServiceProvider;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\Backend\Observers\TaxonomyObserver;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Observers\MenuObserver;
use Juzaweb\Backend\Observers\PostObserver;

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
    }

    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->registerRouteMacros();
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Field', Field::class);
        });
    }

    protected function bootMiddlewares()
    {
        $this->app['router']->aliasMiddleware('admin', Admin::class);
    }

    protected function bootPublishes()
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cms');
        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/juzaweb'),
        ], 'cms_views');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cms');
        $this->publishes([
            __DIR__ . '/../resources/lang' => resource_path('lang/vendor/juzaweb'),
        ], 'cms_lang');

        $this->publishes([
            __DIR__ . '/../resources/assets' => public_path('jw-styles/juzaweb'),
        ], 'cms_assets');
    }

    protected function registerRouteMacros()
    {
        Router::mixin(new RouterMacros());
    }
}
