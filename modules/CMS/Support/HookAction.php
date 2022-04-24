<?php
/**
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Facades\Hook;
use Juzaweb\CMS\Traits\HookAction\GetHookAction;
use Juzaweb\CMS\Traits\HookAction\RegisterHookAction;

class HookAction
{
    use RegisterHookAction,
        GetHookAction,
        Macroable;

    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void
    {
        Hook::addAction($tag, $callback, $priority, $arguments);
    }

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void
    {
        Hook::addFilter($tag, $callback, $priority, $arguments);
    }

    public function applyFilters($tag, $value, ...$args): mixed
    {
        return Hook::filter($tag, $value, ...$args);
    }

    /**
     * Add setting form
     * @param string $key
     * @param array $args
     *      - name : Name form setting
     *      - view : View form setting
     */
    public function addSettingForm($key, $args = []): void
    {
        $defaults = [
            'name' => '',
            'key' => $key,
            'view' => '',
            'priority' => 10,
        ];

        $args = array_merge($defaults, $args);

        GlobalData::set('setting_forms.' . $key, new Collection($args));
    }

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
        $adminMenu = GlobalData::get('admin_menu');

        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'slug' => str_replace('.', '-', $menuSlug),
            'icon' => 'fa fa-list-ul',
            'url' => str_replace('.', '/', $menuSlug),
            'parent' => null,
            'position' => 20,
            'turbolinks' => true,
        ];

        $item = array_merge($opts, $args);
        if ($item['parent']) {
            $adminMenu[$item['parent']]['children'][$item['key']] = $item;
        } else {
            if (Arr::has($adminMenu, $item['key'])) {
                if (Arr::has($adminMenu[$item['key']], 'children')) {
                    $item['children'] = $adminMenu[$item['key']]['children'];
                }

                $adminMenu[$item['key']] = $item;
            } else {
                $adminMenu[$item['key']] = $item;
            }
        }

        GlobalData::set('admin_menu', $adminMenu);

        return true;
    }

    public function enqueueScript($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        GlobalData::push(
            'scripts',
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }

    public function enqueueStyle($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        GlobalData::push(
            'styles',
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }

    public function enqueueFrontendScript($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        GlobalData::push(
            'frontend.scripts',
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }

    public function enqueueFrontendStyle($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        GlobalData::push(
            'frontend.styles',
            new Collection(
                [
                    'key' => $key,
                    'src' => $src,
                    'ver' => $ver,
                    'inFooter' => $inFooter,
                ]
            )
        );
    }
}
