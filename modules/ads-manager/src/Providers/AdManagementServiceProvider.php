<?php

namespace Juzaweb\Modules\AdsManagement\Providers;

use Illuminate\Support\Facades\File;
use Juzaweb\Modules\AdsManagement\Ads;
use Juzaweb\Modules\AdsManagement\AdsRepository;
use Juzaweb\Modules\Core\Facades\Menu;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class AdManagementServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerMenus();
    }

    public function register(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
        $this->app->register(RouteServiceProvider::class);

        $this->app->singleton(Ads::class, AdsRepository::class);
    }

    protected function registerMenus(): void
    {
        Menu::make('ad-management', function () {
            return [
                'title' => __('ad-management::translation.ad_management'),
                'icon' => 'fa fa-image',
                'priority' => 40,
            ];
        });

        Menu::make('banner-ads', function () {
            return [
                'title' => __('ad-management::translation.banner_ads'),
                'parent' => 'ad-management',
                'permissions' => ['banner-ads.index'],
            ];
        });

        Menu::make('video-ads', function () {
            return [
                'title' => __('ad-management::translation.video_ads'),
                'parent' => 'ad-management',
                'permissions' => ['video-ads.index'],
            ];
        });
    }

    protected function registerConfig(): void
    {
        $this->publishes([
            __DIR__ . '/../../config/ad-management.php' => config_path('ad-management.php'),
        ], 'ad-management-config');
        $this->mergeConfigFrom(__DIR__ . '/../../config/ad-management.php', 'ad-management');
    }

    protected function registerTranslations(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'ad-management');
    }

    protected function registerViews(): void
    {
        $viewPath = resource_path('views/modules/ad-management');

        $sourcePath = __DIR__ . '/../resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', 'ad-management-module-views']);

        $this->loadViewsFrom($sourcePath, 'ad-management');
    }
}
