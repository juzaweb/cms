<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Observers;

use Juzaweb\Backend\Models\Post;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Facades\Site;

class PostObserver
{
    public function deleting(Post $post)
    {
        global $site;

        $menuItems = $post->menuItems()->get(['menu_id']);
        $menus = $menuItems->map(function ($item) {
            return $item->menu_id;
        })->toArray();

        foreach ($menus as $menu) {
            Cache::store('file')->pull("menu_items_menu_{$menu}_" . $site->id);
        }

        foreach ($menuItems as $item) {
            $item->delete();
        }
    }

    public function updating(Post $post)
    {
        global $site;

        $menuItems = $post->menuItems()->get(['menu_id']);
        $menus = $menuItems->map(function ($item) {
            return $item->menu_id;
        })->toArray();

        foreach ($menus as $menu) {
            Cache::store('file')->pull("menu_items_menu_{$menu}_" . $site->id);
        }
    }
}
