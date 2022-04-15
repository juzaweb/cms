<?php
/**
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Support;

use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Traits\HookActionGet;
use Juzaweb\Backend\Traits\HookActionRegister;
use Juzaweb\CMS\Facades\GlobalData;
use Juzaweb\CMS\Facades\Hook;

class HookAction
{
    use HookActionRegister, HookActionGet;

    public function addAction($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addAction($tag, $callback, $priority, $arguments);
    }

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1)
    {
        Hook::addFilter($tag, $callback, $priority, $arguments);
    }

    public function applyFilters($tag, $value, ...$args)
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
    public function addSettingForm($key, $args = [])
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

    /**
     * Sync taxonomies post type
     *
     * @param string $postType
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param array $attributes
     * @return void
     *
     * @throws \Exception
     */
    public function syncTaxonomies($postType, $model, array $attributes)
    {
        $taxonomies = $this->getTaxonomies($postType);

        foreach ($taxonomies as $taxonomy) {
            if (method_exists($model, 'taxonomies')) {
                $data = Arr::get($attributes, $taxonomy->get('taxonomy'), []);
                $detachIds = $model->taxonomies()
                    ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                    ->whereNotIn('id', $data)
                    ->pluck('id')
                    ->toArray();

                $model->taxonomies()->detach($detachIds);
                $model->taxonomies()
                    ->syncWithoutDetaching(combine_pivot($data, [
                        'term_type' => $postType,
                    ]), ['term_type' => $postType]);
            }
        }
    }

    public function enqueueScript($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (! is_url($src)) {
            $src = asset($src);
        }

        GlobalData::push('scripts', new Collection([
            'key' => $key,
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]));
    }

    public function enqueueStyle($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (! is_url($src)) {
            $src = asset($src);
        }

        GlobalData::push('styles', new Collection([
            'key' => $key,
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]));
    }

    public function enqueueFrontendScript($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (! is_url($src)) {
            $src = theme_assets($src);
        }

        GlobalData::push('frontend.scripts', new Collection([
            'key' => $key,
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]));
    }

    public function enqueueFrontendStyle($key, $src = '', $ver = '1.0', $inFooter = false)
    {
        if (! is_url($src)) {
            $src = theme_assets($src);
        }

        GlobalData::push('frontend.styles', new Collection([
            'key' => $key,
            'src' => $src,
            'ver' => $ver,
            'inFooter' => $inFooter,
        ]));
    }
}
