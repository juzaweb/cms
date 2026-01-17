<?php

namespace Juzaweb\Themes\Itube\Providers;

use Juzaweb\Modules\Core\Facades\PageBlock;
use Juzaweb\Modules\Core\Facades\PageTemplate;
use Juzaweb\Modules\Core\Providers\ServiceProvider;

class StyleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        PageBlock::make(
            'trending-videos',
            function () {
                return [
                    'label' => __('itube::translation.trending_videos'),
                    'form' => 'itube::blocks.trending-videos.form',
                    'view' => 'itube::blocks.trending-videos.view',
                ];
            }
        );

        PageBlock::make(
            'videos-by-category',
            function () {
                return [
                    'label' => __('itube::translation.videos_by_category'),
                    'form' => 'itube::blocks.videos-by-category.form',
                    'view' => 'itube::blocks.videos-by-category.view',
                ];
            }
        );

        PageTemplate::make(
            'home',
            function () {
                return [
                    'label' => __('itube::translation.home'),
                    'view' => 'itube::templates.home',
                    'blocks' => [
                        'content' => __('itube::translation.content'),
                    ],
                ];
            }
        );

        PageTemplate::make(
            'contact',
            function () {
                return [
                    'label' => __('itube::translation.contact'),
                    'view' => 'itube::templates.contact',
                ];
            }
        );
    }

    public function register()
    {
        //
    }
}
