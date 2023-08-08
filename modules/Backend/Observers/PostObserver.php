<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Observers;

use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function deleting(Post $post): void
    {
        $post->taxonomies()
            ->update(['total_post' => DB::raw('total_post - 1')]);

        $menuItems = $post->menuItems()->get(['menu_id']);
        $menus = $menuItems->map(
            function ($item) {
                return $item->menu_id;
            }
        )->toArray();

        foreach ($menus as $menu) {
            Cache::store('file')->pull(cache_prefix("menu_items_menu_{$menu}"));
        }

        foreach ($menuItems as $item) {
            $item->delete();
        }
    }

    public function updating(Post $post): void
    {
        $menuItems = $post->menuItems()->get(['menu_id']);
        $menus = $menuItems->map(fn($item) => $item->menu_id)->toArray();

        foreach ($menus as $menu) {
            Cache::store('file')->pull(cache_prefix("menu_items_menu_{$menu}"));
        }

        Cache::store('file')->pull("post_type.get_content.{$post->id}");
    }
}
