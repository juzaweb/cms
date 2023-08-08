<?php
/**
 * @package    juzaweb/cms
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

     /**
     * Adds an action to the hook system.
     *
     * @param string $tag The tag name of the action.
     * @param callable $callback The callback function to be executed when the action is triggered.
     * @param int $priority The priority of the action. Default is 20.
     * @param int $arguments The number of arguments the callback function accepts. Default is 1.
     * @return void
     */
    public function addAction($tag, $callback, $priority = 20, $arguments = 1): void
    {
        $this->hook->addAction($tag, $callback, $priority, $arguments);
    }

     /**
     * Adds a filter to the specified tag.
     *
     * @param string $tag The name of the tag to add the filter to.
     * @param callable $callback The callback function to be called when the filter is applied.
     * @param int $priority The priority of the filter. Default is 20.
     * @param int $arguments The number of arguments that the callback function accepts. Default is 1.
     * @throws Exception If there is an error adding the filter.
     * @return void
     */
    public function addFilter($tag, $callback, $priority = 20, $arguments = 1): void
    {
        $this->hook->addFilter($tag, $callback, $priority, $arguments);
    }

     /**
     * Apply filters to a given value using a specified tag.
     *
     * @param string $tag The tag to apply filters to.
     * @param mixed $value The value to apply filters to.
     * @param mixed ...$args Additional arguments to pass to the filters.
     * @return mixed The filtered value.
     */
    public function applyFilters(string $tag, mixed $value, ...$args): mixed
    {
        return $this->hook->filter($tag, $value, ...$args);
    }

     /**
     * Add a setting form to the system.
     *
     * @param string $key The unique identifier for the setting form.
     * @param array $args An array of optional arguments for the setting form.
     *                    - name: The name of the setting form.
     *                    - key: The key of the setting form.
     *                    - view: The view for the setting form.
     *                    - header: Whether to show the header of the setting form.
     *                    - footer: Whether to show the footer of the setting form.
     *                    - priority: The priority of the setting form.
     *                    - page: The page to display the setting form on.
     * @return void
     */
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

     /**
     * Adds thumbnail sizes to a specific post type.
     *
     * @param string $postType The post type to add thumbnail sizes to.
     * @param string|array $size The size(s) to add. Can be a string or an array of strings.
     * @throws \Exception If the size parameter is not an array.
     * @return void
     */
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
