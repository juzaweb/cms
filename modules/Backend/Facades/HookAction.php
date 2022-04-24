<?php

namespace Juzaweb\Backend\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\HookActionContract;

/**
 * @method static addAdminMenu(string $menuTitle, $menuSlug, array $args)
 * @method static registerMenuItem(string $key, $componentClass)
 * @method static registerPostType(string $key, $args = [])
 * @method static registerTaxonomy(string $taxonomy, $objectType, $args = [])
 * @method static registerPermalink(string $key, array $args = [])
 * @method static addSettingForm($key, $args = [])
 * @method static mixed applyFilters($tag, $value, ...$args)
 * @method static void addFilter($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void addAction($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void registerMenuBox($tag, array $args = [])
 * @method static void enqueueScript($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueStyle($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueFrontendScript($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueFrontendStyle($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void registerNavMenus($locations = [])
 * @method static void registerPageBlock($key, $args = [])
 * @method static void registerWidget($key, $args = [])
 * @method static void registerEmailHook(string $key, $args = [])
 * @method static void registerSidebar(string $key, $args = [])
 * @method static void registerFrontendAjax(string $key, $args = [])
 * @method static void registerThemeTemplate(string $key, $args = [])
 * @method static void registerAdminPage(string $key, $args = [])
 * @method static void registerAdminAjax(string $key, $args = [])
 * @method static void registerPackageModule(string $key, $args = [])
 * @method static void registerResource(string $key, $postType = null, $args = [])
 * @method static void registerConfig(array $keys)
 * @method static void registerThemeSetting($name, $label, $args = [])
 * @method static array getMenuBoxs(array $keys = [])
 * @method static \Illuminate\Support\Collection getMenuBox(string $key)
 * @method static \Illuminate\Support\Collection getPermalinks(string $key = null)
 * @method static \Illuminate\Support\Collection getPostTypes($postType = null)
 * @method static \Illuminate\Support\Collection getTaxonomies($postType = null)
 * @method static \Illuminate\Support\Collection getEmailHooks($key = null)
 * @method static \Illuminate\Support\Collection getWidgets($key = null)
 * @method static \Illuminate\Support\Collection getPageBlocks($key = null)
 * @method static \Illuminate\Support\Collection getSidebars($key = null)
 * @method static \Illuminate\Support\Collection getThemeTemplates($key = null)
 * @method static \Illuminate\Support\Collection getEnqueueFrontendScripts($key = null)
 * @method static \Illuminate\Support\Collection getEnqueueFrontendStyles($key = null)
 * @method static \Illuminate\Support\Collection getFrontendAjaxs($key = null)
 * @method static \Illuminate\Support\Collection getResource($key = null)
 * @method static \Illuminate\Support\Collection getAdminAjaxs($key = null)
 * @method static \Illuminate\Support\Collection getAdminPages($key = null)
 * @method static \Illuminate\Support\Collection getPackageModules($key = null)
 * @method static \Illuminate\Support\Collection getThemeSettings($name = null)
 * @method static \Illuminate\Support\Collection getEnqueueScripts($inFooter = false)
 *
 * @see \Juzaweb\CMS\Support\HookAction
 */
class HookAction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return HookActionContract::class;
    }
}
