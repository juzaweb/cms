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

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Http\Resources\MenuItemResource;
use Juzaweb\Backend\Models\MenuItem;
use Juzaweb\CMS\Facades\HookAction;

class MenuBuilder implements Arrayable
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

    public function render(): string
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

        return $this->args['item_view']->render(
            [
                'items' => $items
            ]
        );
    }

    protected function buildItems($items): array
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

    public function toArray(): array
    {
        return $this->buildItems($this->items());
    }
}
