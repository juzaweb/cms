<?php

namespace Tadcms\System\Supports;

use Illuminate\Support\Facades\View;
use Tadcms\System\Traits\MenuHookAction;
use Tadcms\System\Traits\PostTypeHookAction;

/**
 * Class HookAction
 *
 * @package    Tadcms\Tadcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/tadcms/tadcms
 * @license    MIT
 */
class HookAction
{
    use PostTypeHookAction, MenuHookAction;

    /**
     * TAD CMS: Add setting form
     *
     * @param string $path
     **/
    public function loadActionForm($path)
    {
        add_filters('tadcms.actions', function ($items) use ($path) {
            $items[] = $path;
            return collect($items)->unique();
        });
    }

    /**
     * TAD CMS: Add setting form
     * @param string $key
     * @param array $args
     **/
    public function addSettingForm($key, $args = [])
    {

    }

    /**
     * TAD CMS: Add input to general setting form
     * @param string $view
     **/
    public function addGeneralSettingInput($view)
    {
        add_action('setting.form_general', function () use ($view) {
            echo View::make($view)->render();
        });
    }

    /**
     * TAD CMS: Registers menu item in menu builder.
     * @param string $key
     * @param array $args
     * @throws \Exception
     * */
    public function registerPermalink($key, $args = [])
    {
        if (empty($args['label'])) {
            throw new \Exception('Permalink args label is required');
        }

        if (empty($args['base'])) {
            throw new \Exception('Permalink args default_base is required');
        }

        add_filters('tadcms.permalinks', function ($items) use ($key, $args) {
            array_merge([
                'label' => '',
                'base' => '',
                'callback' => '',
                'position' => 20,
            ], $args);

            $args['key'] = $key;
            $items[$key] = collect($args);
            return $items;
        });
    }
}
