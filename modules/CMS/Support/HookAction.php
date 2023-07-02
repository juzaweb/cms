<?php
/**
 * @package    juzaweb/juzacms
 * @author     JuzaWeb Team
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\CMS\Contracts\EventyContract;
use Juzaweb\CMS\Contracts\GlobalDataContract;
use Juzaweb\CMS\Contracts\HookActionContract;
use Juzaweb\CMS\Support\HookActions\Traits\MenuHookAction;
use Juzaweb\CMS\Support\HookActions\Traits\StyleHookAction;
use Juzaweb\CMS\Traits\HookAction\GetHookAction;
use Juzaweb\CMS\Traits\HookAction\RegisterHookAction;

class HookAction implements HookActionContract
{
    use Macroable, RegisterHookAction, GetHookAction, MenuHookAction, StyleHookAction;

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
