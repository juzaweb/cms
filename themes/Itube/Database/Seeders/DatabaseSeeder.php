<?php

namespace Juzaweb\Themes\Itube\Database\Seeders;

use Juzaweb\Modules\Core\Models\Menus\Menu;
use Juzaweb\Modules\Core\Models\Pages\Page;
use Juzaweb\Modules\Core\Themes\Contracts\ThemeSeeder;

class DatabaseSeeder implements ThemeSeeder
{
    public function run(): void
    {
        $this->setupHomePage();
    }

    protected function setupHomePage()
    {
        if (!theme_setting('home_page')) {
            return;
        }

        $mainMenu = Menu::firstOrCreate([
            'name' => 'Main',
        ]);

        if ($mainMenu->items()->count() == 1) {
            $mainMenu->items->each->delete();
        }

        $homePage = Page::find(theme_setting('home_page'));
        $homePage->template = 'home';
        $homePage->save();

        $homePage->blocks()->firstOrCreate(
            [
                'block' => 'trending-videos',
                'container' => 'content',
            ],
            [
                'label' => 'Trending Videos',
                'data' => [
                    'limit' => 8,
                    'block' => 'trending-videos',
                ],
                'display_order' => 1,
            ]
        );

        $homePage->blocks()->firstOrCreate(
            [
                'block' => 'videos-by-category',
                'container' => 'content',
            ],
            [
                'label' => 'Funny Cats',
                'data' => [
                    'limit' => 12,
                    'block' => 'videos-by-category',
                ],
                'display_order' => 2,
            ]
        );
    }
}
