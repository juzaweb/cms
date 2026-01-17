<?php

namespace Juzaweb\Themes\Itech\Database\Seeders;

use Juzaweb\Modules\Admin\Networks\Facades\Network;
use Juzaweb\Modules\Core\Models\Menus\Menu;
use Juzaweb\Modules\Core\Models\Pages\Page;
use Juzaweb\Modules\Core\Models\ThemeSidebar;
use Juzaweb\Modules\Core\Themes\Contracts\ThemeSeeder;

class DatabaseSeeder implements ThemeSeeder
{
    public function run(): void
    {
        $this->setupHomePage();

        ThemeSidebar::create([
            'sidebar' => 'sidebar',
            'widget' => 'most-popular',
            'data' => [
                'limit' => 5,
            ],
            'theme' => 'itech',
            'display_order' => 1,
        ]);

        ThemeSidebar::create([
            'sidebar' => 'sidebar',
            'widget' => 'tags',
            'data' => [],
            'theme' => 'itech',
            'display_order' => 2,
        ]);

        // Create footer menu
        $footerMenu = Menu::firstOrCreate([
            'name' => 'Footer',
        ]);

        $privacyPolicy = Page::whereTranslation('slug', 'privacy-policy')->first();
        $termsOfService = Page::whereTranslation('slug', 'terms-of-service')->first();

        if ($privacyPolicy) {
            $footerMenu->items()->create(
                [
                    'menuable_type' => Page::class,
                    'menuable_id' => $privacyPolicy->id,
                    'box_key' => 'pages',
                    'display_order' => 1,
                    $website->language => [
                        'label' => 'Privacy Policy',
                    ],
                ]
            );
        }

        if ($termsOfService) {
            $footerMenu->items()->create(
                [
                    'menuable_type' => Page::class,
                    'menuable_id' => $termsOfService->id,
                    'box_key' => 'pages',
                    'display_order' => 2,
                    $website->language => [
                        'label' => 'Terms of Service',
                    ],
                ]
            );
        }

        $locations = theme_setting('nav_location', []);
        $locations['footer'] = $footerMenu->id;
        theme_setting()?->set('nav_location', $locations);
    }

    protected function setupHomePage()
    {
        if (!theme_setting('home_page')) {
            return;
        }

        $homePage = Page::find(theme_setting('home_page'));
        $homePage->template = 'home';
        $homePage->save();

        $homePage->blocks()->firstOrCreate(
            [
                'block' => 'hot-posts',
                'container' => 'hot-posts',
            ],
            [
                'label' => 'Hot Posts',
                'data' => [
                    'category' => null,
                    'block' => 'hot-posts',
                ],
                'display_order' => 1,
            ]
        );

        $homePage->blocks()->firstOrCreate(
            [
                'block' => 'breaking-carousel',
                'container' => 'breaking',
            ],
            [
                'label' => 'Breaking News Carousel',
                'data' => [
                    'type' => 'recent',
                    'limit' => 6,
                    'block' => 'breaking-carousel',
                ],
                'display_order' => 2,
            ]
        );

        $homePage->blocks()->firstOrCreate(
            [
                'block' => 'featured-posts',
                'container' => 'featured-posts',
            ],
            [
                'label' => 'Featured Posts',
                'data' => [
                    'category' => null,
                    'block' => 'featured-posts',
                ],
                'display_order' => 3,
            ]
        );
    }
}
