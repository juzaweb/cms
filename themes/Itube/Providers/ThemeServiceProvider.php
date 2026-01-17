<?php

namespace Juzaweb\Themes\Itube\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Modules\AdsManagement\Facades\Ads;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Facades\NavMenu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(StyleServiceProvider::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'itube');

        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'itube');

        $this->mergeConfigFrom(
            __DIR__ . '/../config/itube.php',
            'itube'
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->registerVideoAdPositions();
        $this->registerBannerAdPositions();

        NavMenu::make(
            'main',
            function () {
                return [
                    'label' => __('itube::translation.main_menu'),
                ];
            }
        );

        NavMenu::make(
            'footer',
            function () {
                return [
                    'label' => __('itube::translation.footer_menu'),
                ];
            }
        );

        $this->booted(
            function () {
                if (File::missing(storage_path('app/installed'))) {
                    return;
                }

                Menu::make('theme-settings', function () {
                    return [
                        'title' => __('itube::translation.settings'),
                        'url' => 'theme/settings',
                        'parent' => 'appearance',
                        'priority' => 99,
                        'permissions' => ['theme.settings'],
                    ];
                });
            }
        );
    }

    protected function registerVideoAdPositions(): void
    {
        if (!is_bound(\Juzaweb\Modules\AdsManagement\Ads::class)) {
            return;
        }

        Ads::position('video-player', function () {
            return [
                'name' => __('itube::translation.video_player'),
                'type' => 'video',
            ];
        });

        Ads::position('sidebar-video', function () {
            return [
                'name' => __('itube::translation.sidebar_video'),
                'size' => '300x250',
                'type' => 'banner',
            ];
        });

        Ads::enableVideoAds(true);
    }

    protected function registerBannerAdPositions(): void
    {
        Ads::position('home_banner', function () {
            return [
                'label' => __('itube::translation.home_banner'),
                'size' => '728x90',
                'type' => 'banner',
            ];
        });
    }
}
