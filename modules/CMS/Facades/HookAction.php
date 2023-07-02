<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\HookActionContract;

/**
 * @method static void addAdminMenu(string $menuTitle, $menuSlug, array $args)
 * @method static void addMasterAdminMenu(string $menuTitle, $menuSlug, array $args)
 * @method static void registerMenuItem(string $key, $componentClass)
 * @method static void registerPostType(string $key, $args = [])
 * @method static void registerTaxonomy(string $taxonomy, $objectType, $args = [])
 * @method static void registerPermalink(string $key, array $args = [])
 * @method static void addSettingForm($key, $args = [])
 * @method static mixed applyFilters($tag, $value, ...$args)
 * @method static void addFilter($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void addAction($tag, $callback, $priority = 20, $arguments = 1)
 * @method static void registerMenuBox($tag, array $args = [])
 * @method static void enqueueScript($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueStyle($key, $src = '', $ver = '1.0', $inFooter = false)
 * @method static void enqueueFrontendScript($key, $src = '', $ver = '1.0', $inFooter = false, $options = [])
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
 * @method static void registerConfig(array|string $key, array $args = [])
 * @method static void registerThemeSetting($name, $label, $args = [])
 * @method static void registerProfilePage(string $key, array $args = [])
 * @method static void registerPermission(string $key, array $args = [])
 * @method static void registerResourcePermissions(string $resource, string $name)
 * @method static array getMenuBoxs(array $keys = [])
 * @method static array getMasterAdminMenu()
 * @method static Collection getMenuBox(string $key)
 * @method static Collection getPermalinks(string $key = null)
 * @method static Collection getPostTypes($postType = null)
 * @method static Collection getTaxonomies($postType = null)
 * @method static Collection getEmailHooks($key = null)
 * @method static Collection getWidgets($key = null)
 * @method static Collection getPageBlocks($key = null)
 * @method static Collection getSidebars($key = null)
 * @method static Collection getThemeTemplates($key = null)
 * @method static Collection getEnqueueFrontendScripts($inFooter = false)
 * @method static Collection getEnqueueFrontendStyles($inFooter = false)
 * @method static Collection getFrontendAjaxs($key = null)
 * @method static Collection getResource($key = null)
 * @method static Collection getAdminAjaxs($key = null)
 * @method static Collection getAdminPages($key = null)
 * @method static Collection getPackageModules($key = null)
 * @method static Collection getProfilePages($key = null)
 * @method static Collection getThemeSettings($name = null)
 * @method static Collection getEnqueueScripts($inFooter = false)
 * @method static Collection getEnqueueStyles($inFooter = false)
 * @method static Collection getPermissionGroups(string $key = null)
 * @method static Collection getPermissions(string $key = null)
 * @method static Collection getConfigs(string $key = null)
 * @method static Collection getThumbnailSizes(string $postType = null)
 * @method static void addMetaPostTypes(string $postType, array $metas)
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
    protected static function getFacadeAccessor(): string
    {
        return HookActionContract::class;
    }
}
