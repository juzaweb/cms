<?php
/**
 * @package    juzaweb/juzacms
 * @author     JuzaWeb Team
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\CMS\Contracts\EventyContract;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Traits\HookAction\GetHookAction;
use Juzaweb\CMS\Traits\HookAction\RegisterHookAction;

class HookAction implements HookActionContract
{
    use RegisterHookAction, GetHookAction, Macroable;

    protected EventyContract $hook;

    protected GlobalDataContract $globalData;

    public function __construct(
        EventyContract $hook,
        GlobalDataContract $globalData
    ) {
        $this->hook = $hook;
        $this->globalData = $globalData;
    }

    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void
    {
        $this->hook->addAction($tag, $callback, $priority, $arguments);
    }

    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void
    {
        $this->hook->addFilter($tag, $callback, $priority, $arguments);
    }

    public function applyFilters(string $tag, mixed $value, ...$args): mixed
    {
        return $this->hook->filter($tag, $value, ...$args);
    }

    public function addSettingForm(string $key, array $args = []): void
    {
        $defaults = [
            'name' => '',
            'key' => $key,
            'view' => null,
            'header' => true,
            'footer' => true,
            'priority' => 10,
            'page' => 'system',
        ];

        // Merge the provided arguments with the default values.
        $args = array_merge($defaults, $args);

        // Set the setting form data in the global data collection using the provided key.
        // Uses a new Collection instance created from the merged arguments.
        $this->globalData->set('setting_forms.' . $key, new Collection($args));
    }

    public function addAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    {
        $adminMenu = $this->globalData->get('admin_menu');

        $opts = [
            'title' => $menuTitle,
            'key' => $menuSlug,
            'permissions' => ['admin'],
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

        $this->globalData->set('admin_menu', $adminMenu);
    }

    public function addMasterAdminMenu(string $menuTitle, string $menuSlug, array $args = []): void
    {
        $adminMenu = $this->globalData->get('master_admin_menu');

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

        $this->globalData->set('master_admin_menu', $adminMenu);
    }

    public function addThumbnailSizes(string $postType, string|array $size): void
    {
        if (!is_array($size)) {
            $size = [$size];
        }

        $currentSizes = $this->globalData->get("thumbnail_sizes.{$postType}", []);
        foreach ($size as $item) {
            list($width, $height) = explode('x', $item);
            $currentSizes[$item] = compact('width', 'height');
        }

        $this->globalData->set("thumbnail_sizes.{$postType}", new Collection($currentSizes));
    }

    public function enqueueScript(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        $this->globalData->set(
            "scripts.{$key}",
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

    public function enqueueStyle(string $key, string $src = '', string $ver = '1.0', bool $inFooter = false): void
    {
        if (!is_url($src)) {
            $src = asset($src);
        }

        $this->globalData->set(
            "styles.{$key}",
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

    public function enqueueFrontendScript(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        $this->globalData->set(
            "frontend_scripts.{$key}",
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

    public function enqueueFrontendStyle(
        string $key,
        string $src = '',
        string $ver = '1.0',
        bool $inFooter = false
    ): void {
        if (!is_url($src)) {
            $src = theme_assets($src);
        }

        $this->globalData->set(
            "frontend_styles.{$key}",
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

    public function addMetaPostTypes(string $postType, array $metas): void
    {
        $postTypeData = $this->getPostTypes($postType);

        if ($postTypeData->isEmpty()) {
            return;
        }

        $metas = array_merge($postTypeData->get('metas', []), $metas);

        $postTypeData->put('metas', $metas);

        $this->registerPostType($postType, $postTypeData->toArray());
    }
}
