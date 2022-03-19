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

use Juzaweb\Backend\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Juzaweb\Facades\Site;

class MenuObserver
{
    public function saved(Menu $menu)
    {
        Cache::store('file')->pull(cache_prefix("menu_items_menu_{$menu->id}_"));
    }

    public function deleted(Menu $menu)
    {
        Cache::store('file')->pull(cache_prefix("menu_items_menu_{$menu->id}"));
    }
}
