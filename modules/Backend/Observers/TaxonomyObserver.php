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

use Illuminate\Support\Facades\Cache;
use Juzaweb\Backend\Models\Taxonomy;

class TaxonomyObserver
{
    public function deleting(Taxonomy $taxonomy): void
    {
        $menuItems = $taxonomy->menuItems()->get(['menu_id']);
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

    public function updating(Taxonomy $taxonomy): void
    {
        $menuItems = $taxonomy->menuItems()->get(['menu_id']);
        $menus = $menuItems->map(
            function ($item) {
                return $item->menu_id;
            }
        )->toArray();

        foreach ($menus as $menu) {
            Cache::store('file')->pull(cache_prefix("menu_items_menu_{$menu}"));
        }
    }
}
