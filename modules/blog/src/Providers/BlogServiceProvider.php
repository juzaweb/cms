<?php

namespace Juzaweb\Modules\Blog\Providers;

use Juzaweb\Modules\Blog\Models\CategoryTranslation;
use Juzaweb\Modules\Blog\Models\PostTranslation;
use Juzaweb\Modules\Core\Contracts\Sitemap;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app[Sitemap::class]->register('post-categories', CategoryTranslation::class);
        $this->app[Sitemap::class]->register('posts', PostTranslation::class);

        $this->registerMenus();
    }

    public function register(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->app->register(RouteServiceProvider::class);
    }

    protected function registerMenus(): void
    {
        Menu::make('blog', function () {
            return [
                'title' => __('core::translation.blog'),
                'icon' => 'fas fa-newspaper',
            ];
        });

        Menu::make('posts', function () {
            return [
                'title' => __('core::translation.posts'),
                'parent' => 'blog',
            ];
        });

        Menu::make('post-categories', function () {
            return [
                'title' => __('core::translation.categories'),
                'parent' => 'blog',
            ];
        });

        Menu::make('comments', function () {
            return [
                'title' => __('core::translation.comments'),
                'parent' => 'blog',
            ];
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../config/config.php' => config_path('blog.php'),
        ], 'blog-config');
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'blog');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'blog');
        $this->loadJsonTranslationsFrom(__DIR__ . '/../resources/lang');
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/blog');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'blog-module-views']);

        $this->loadViewsFrom($sourcePath, 'blog');
    }
}
