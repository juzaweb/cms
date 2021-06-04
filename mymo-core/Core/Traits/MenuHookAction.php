<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Mymo\Core\Traits;

use Illuminate\Support\Arr;

trait MenuHookAction
{
    /**
     * Add a top-level menu page.
     *
     * This function takes a capability which will be used to determine whether
     * or not a page is included in the menu.
     *
     * The function which is hooked in to handle the output of the page must check
     * that the user has the required capability as well.
     *
     * @param string $menuTitle The trans key to be used for the menu.
     * @param string $menuSlug The url name to refer to this menu by. not include admin-cp
     * @param array $args
     * - string $icon Url icon or fa icon fonts
     * - string $parent The parent of menu. Default null
     * - int $position The position in the menu order this item should appear.
     * @return bool.
     */
    public function addAdminMenu($menuTitle, $menuSlug, $args = [])
    {
        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'icon' => 'fa fa-list-ul',
            'url' => str_replace('.', '/', $menuSlug),
            'parent' => null,
            'position' => 20,
        ];
        $item = array_merge($opts, $args);

        return add_filters('mymo.admin_menu', function ($menu) use ($item) {
            if ($item['parent']) {
                $menu[$item['parent']]['children'][$item['key']] = $item;
            } else {
                if (Arr::has($menu, $item['key'])) {
                    if (Arr::has($menu[$item['key']], 'children')) {
                        $item['children'] = $menu[$item['key']]['children'];
                    }
                    $menu[$item['key']] = $item;
                } else {
                    $menu[$item['key']] = $item;
                }
            }

            return $menu;
        });
    }

    /**
     * Registers menu item in menu builder.
     *
     * @param string $key
     * @param array $args
     *      - label (Required): Label for item
     *      - component (Required): Menu item class handle
     * @throws \Exception
     * */
    public function registerMenuItem($key, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Args label is required');
        }

        if (empty($args['component'])) {
            throw new \Exception('Args component is required');
        }

        add_filters('mymo.menu_blocks', function ($items) use ($key, $args) {
            array_merge([
                'label' => '',
                'component' => '',
                'position' => 20
            ], $args);
            $args['key'] = $key;

            $items[$key] = collect($args);
            return $items;
        });
    }
}
