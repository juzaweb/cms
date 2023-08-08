<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support\Theme;

use Illuminate\Support\Collection;
use Juzaweb\Backend\Models\MenuItem;
use Juzaweb\CMS\Facades\HookAction;

class BackendMenuBuilder
{
    protected Collection|array $items;
    protected array $args;

    /**
     * @param  Collection|MenuItem[]  $items
     * @param  array  $args
     */
    public function __construct(array|Collection $items, array $args = [])
    {
        $this->items = $items;
        $this->args = $args;
    }

    public function items($parentId = null)
    {
        $items = $this->items->where('parent_id', $parentId);
        $groups = $items->groupBy('box_key')->keys()->toArray();

        $menuBoxs = HookAction::getMenuBoxs($groups);
        $menuBoxs = array_map(
            fn ($item) => $item->get('menu_box'),
            $menuBoxs
        );

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
     * @param  Collection  $item
     * @return string
     */
    public function buildItem($item)
    {
        $children = $this->items($item->id);

        return $this->args['item_view']->with(
            [
            'item' => $item,
            'children' => $children,
            'builder' => $this,
            ]
        )->render();
    }
}
