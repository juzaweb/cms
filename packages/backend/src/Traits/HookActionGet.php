<?php

namespace Juzaweb\Backend\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Juzaweb\Facades\GlobalData;

trait HookActionGet
{
    /**
     * Get registed menu box
     *
     * @param string|array $keys
     * @return array
     */
    public function getMenuBoxs($keys = [])
    {
        $menuBoxs = GlobalData::get('menu_boxs');

        if ($keys) {
            if (is_string($keys)) {
                $keys = [$keys];
            }

            return array_only($menuBoxs, $keys);
        }

        return $menuBoxs;
    }

    /**
     * Get registed menu box
     *
     * @param string|array $key
     * @return \Illuminate\Support\Collection|false
     */
    public function getMenuBox($key)
    {
        $menuBoxs = GlobalData::get('menu_boxs.' . $key);

        return $menuBoxs;
    }

    /**
     * Get post type setting
     *
     * @param string|null $postType
     * @return \Illuminate\Support\Collection
     * */
    public function getPostTypes($postType = null)
    {
        if ($postType) {
            return GlobalData::get('post_types.' . $postType);
        }

        return collect(GlobalData::get('post_types'));
    }

    public function getTaxonomies($postType = null)
    {
        $taxonomies = collect(GlobalData::get('taxonomies'));

        if (empty($taxonomies) || empty($postType)) {
            return $taxonomies;
        }

        $taxonomies = collect($taxonomies[$postType] ?? []);
        $taxonomies = $taxonomies ?
            $taxonomies->sortBy('menu_position')
            : [];

        return $taxonomies;
    }

    public function getSettingForms()
    {
        return collect(GlobalData::get('setting_forms'))
            ->sortBy('priority');
    }

    public function getAdminMenu()
    {
        return GlobalData::get('admin_menu');
    }

    public function getPermalinks($key = null)
    {
        $data = get_config('permalinks', []);
        $permalinks = GlobalData::get('permalinks');

        if ($data) {
            $permalinks = array_map(function ($item) use ($data) {
                if (isset($data[$item->get('key')])) {
                    $item->put('base', $data[$item->get('key')]['base']);
                }

                return $item;
            }, $permalinks);
        }

        if ($key) {
            $permalink = Arr::get($permalinks, $key);
            return $permalink;
        }

        return $permalinks;
    }

    public function getEmailHooks($key = null)
    {
        if ($key) {
            return GlobalData::get('email_hooks.' . $key);
        }

        return new Collection(GlobalData::get('email_hooks'));
    }

    public function getWidgets($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('widgets'), $key);
        }

        return new Collection(GlobalData::get('widgets'));
    }

    public function getPageBlocks($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('page_blocks'), $key);
        }

        return new Collection(GlobalData::get('page_blocks'));
    }

    public function getSidebars($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('sidebars'), $key);
        }

        return new Collection(GlobalData::get('sidebars'));
    }

    public function getFrontendAjaxs($key = null)
    {
        if ($key) {
            $data = Arr::get(GlobalData::get('frontend_ajaxs'), $key);

            if ($data) {
                return $data;
            }

            return false;
        }

        $data = new Collection(GlobalData::get('frontend_ajaxs'));

        return $data;
    }

    public function getThemeTemplates($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('templates'), $key);
        }

        return new Collection(GlobalData::get('templates'));
    }

    public function getResource($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('resources'), $key);
        }

        return new Collection(GlobalData::get('resources'));
    }

    public function getAdminPages($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('admin_pages'), $key);
        }

        return new Collection(GlobalData::get('admin_pages'));
    }

    public function getAdminAjaxs($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('admin_ajaxs'), $key);
        }

        return new Collection(GlobalData::get('admin_ajaxs'));
    }

    public function getPackageModules($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('package_modules'), $key);
        }

        return new Collection(GlobalData::get('package_modules'));
    }

    public function getThemeSettings($key = null)
    {
        if ($key) {
            return Arr::get(GlobalData::get('theme_settings'), $key);
        }

        return new Collection(GlobalData::get('theme_settings'));
    }

    public function getEnqueueScripts($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('scripts'));

        return $scripts->where('inFooter', $inFooter);
    }

    public function getEnqueueStyles($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('styles'));

        return $scripts->where('inFooter', $inFooter);
    }

    public function getEnqueueFrontendScripts($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('frontend.scripts'));

        return $scripts->where('inFooter', $inFooter);
    }

    public function getEnqueueFrontendStyles($inFooter = false)
    {
        $scripts = new Collection(GlobalData::get('frontend.styles'));

        return $scripts->where('inFooter', $inFooter);
    }
}
