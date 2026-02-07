<?php

namespace Juzaweb\Themes\Itech\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Modules\AdsManagement\Facades\Ads;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Facades\NavMenu;
use Juzaweb\Modules\Core\Facades\PageBlock;
use Juzaweb\Modules\Core\Facades\PageTemplate;
use Juzaweb\Modules\Core\Facades\Sidebar;
use Juzaweb\Modules\Core\Facades\Thumbnail;
use Juzaweb\Modules\Core\Facades\Widget;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerPages();

        Sidebar::make(
            'sidebar',
            function () {
                return [
                    'label' => __('itech::translation.sidebar'),
                    'description' => __('itech::translation.main_sidebar_for_blog_pages'),
                ];
            }
        );

        Widget::make(
            'most-popular',
            function () {
                return [
                    'label' => __('itech::translation.most_popular'),
                    'description' => __('itech::translation.display_most_popular_posts'),
                    'view' => 'itech::components.widgets.most-popular.show',
                    'form' => 'itech::components.widgets.most-popular.form',
                    'only' => ['sidebar'],
                ];
            }
        );

        Widget::make(
            'tags',
            function () {
                return [
                    'label' => __('itech::translation.tags_cloud'),
                    'description' => __('itech::translation.display_tags_cloud'),
                    'view' => 'itech::components.widgets.tags.show',
                    'form' => 'itech::components.widgets.tags.form',
                    'only' => ['sidebar'],
                ];
            }
        );

        NavMenu::make(
            'main',
            function () {
                return [
                    'label' => __('itech::translation.main_menu'),
                ];
            }
        );

        NavMenu::make(
            'footer',
            function () {
                return [
                    'label' => __('itech::translation.footer_menu'),
                ];
            }
        );

        if (is_bound(\Juzaweb\Modules\AdsManagement\Ads::class)) {
            Ads::position('home_top', function () {
                return [
                    'label' => __('itech::translation.home_top'),
                    'size' => '300x250',
                    'type' => 'banner',
                ];
            });

            Ads::position('sidebar_top', function () {
                return [
                    'label' => __('itech::translation.sidebar_top'),
                    'size' => '300x250',
                    'type' => 'banner',
                ];
            });
        }

        Thumbnail::defaults(
            function () {
                return [
                    Post::class => asset('juzaweb/images/no-thumbnail.png'),
                ];
            }
        );

        Menu::make('theme-settings', function () {
            return [
                'title' => __('itech::translation.settings'),
                'url' => 'theme/settings',
                'parent' => 'appearance',
                'priority' => 99,
                'permissions' => ['theme.settings'],
            ];
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->mergeConfigFrom(
            __DIR__ . '/../../config/itech.php',
            'itech'
        );

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'itech');

        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'itech');
    }

    protected function registerPages(): void
    {
        PageTemplate::make(
            'home',
            function () {
                return [
                    'label' => __('itech::translation.home_page'),
                    'blocks' => [
                        'breaking' => __('itech::translation.breaking_news'),
                        'hot-posts' => __('itech::translation.hot_posts'),
                        'featured-posts' => __('itech::translation.featured_posts'),
                    ],
                ];
            }
        );

        PageBlock::make(
            'breaking-carousel',
            function () {
                return [
                    'label' => __('itech::translation.breaking_carousel'),
                    'form' => 'itech::components.blocks.breaking-carousel-form',
                    'view' => 'itech::components.blocks.breaking-carousel-show',
                    'only' => ['home'],
                ];
            }
        );

        PageBlock::make(
            'hot-posts',
            function () {
                return [
                    'label' => __('itech::translation.hot_posts'),
                    'form' => 'itech::components.blocks.hot-posts-form',
                    'view' => 'itech::components.blocks.hot-posts-show',
                    'only' => ['home'],
                ];
            }
        );

        PageBlock::make(
            'featured-posts',
            function () {
                return [
                    'label' => __('itech::translation.featured_posts'),
                    'form' => 'itech::components.blocks.featured-posts-form',
                    'view' => 'itech::components.blocks.featured-posts-show',
                    'only' => ['home'],
                ];
            }
        );
    }
}
