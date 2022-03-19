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

class MenuBuilder
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

    public function render()
    {
        $str = $this->args['container_before'];
        $items = $this->items();
        $str .= $this->buildMenu($items);
        $str .= $this->args['container_after'];
        return $str;
    }

    /**
     * Build menu item by view
     *
     * @param Collection $items
     * @return string
     * @throws \Throwable
     */
    protected function buildMenu($items)
    {
        $items = $this->buildItems($items);
        return $this->args['item_view']->render([
            'items' => $items
        ]);
    }

    protected function buildItems($items)
    {
        $result = [];
        $request = request();

        foreach ($items as $item) {
            $children = $this->items($item->id);

            $itemResource = (new MenuItemResource($item))
                ->toArray($request);

            if ($children) {
                $itemResource['children'] = $this->buildItems($children);
            }

            $result[] = $itemResource;
        }

        return $result;
    }

    protected function items($parentId = null)
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
}
