<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Theme;

use Illuminate\Support\Collection;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Http\Resources\MenuItemResource;
use Juzaweb\Backend\Models\MenuItem;

class BackendMenuBuilder
{
    protected $items;
    protected $args;

    /**
     * @param MenuItem[]|Collection $items
     * @param array $args
     */
    public function __construct($items, $args = [])
    {
        $this->items = $items;
        $this->args = $args;
    }

    public function items($parentId = null)
    {
        $items = $this->items->where('parent_id', $parentId);
        $groups = $items->groupBy('box_key')->keys()->toArray();

        $menuBoxs = HookAction::getMenuBoxs($groups);
        $menuBoxs = array_map(function ($item) {
            return $item->get('menu_box');
        }, $menuBoxs);

        foreach ($groups as $group) {
            if (empty($menuBoxs[$group])) {
                continue;
            }

            $newItems = $items->where('box_key', $group);
            $newItems = ($menuBoxs[$group])->getLinks($newItems);
            $items->merge($newItems);
        }

        if ($items->isNotEmpty()) {
            return $items;
        }

        return [];
    }

    public function render()
    {
        $str = $this->args['container_before'];
        $items = $this->items();

        foreach ($items as $item) {
            $str .= $this->buildItem($item);
        }

        $str .= $this->args['container_after'];

        return $str;
    }

    /**
     * Build menu item by view
     *
     * @param Collection $item
     * @param boolean $twig
     * @return string
     * @throws \Throwable
     */
    public function buildItem($item)
    {
        $children = $this->items($item->id);

        return $this->args['item_view']->with([
            'item' => $item,
            'children' => $children,
            'builder' => $this,
        ])->render();
    }
}
