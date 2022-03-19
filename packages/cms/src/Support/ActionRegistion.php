<?php

namespace Juzaweb\Support;

use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Foundation\Application;

class ActionRegistion
{
    /**
     * @var CacheManager
     */
    private $cache;

    public function __construct(Application $app)
    {
        $this->cache = $app['cache'];
    }

    public function init()
    {
        $actions = $this->getActions();
        foreach ($actions as $module) {
            foreach ($module as $action) {
                app($action)->handle();
            }
        }
    }

    protected function getActions()
    {
        return $this->cache->store('file')
            ->rememberForever(
                cache_prefix("site_actions"),
                function () {
                    $plugins = get_config('plugin_statuses', []);
                    $plugins = array_keys($plugins);

                    $actions = config('plugin.actions');

                    $actions = collect($actions)
                        ->filter(function ($item, $key) use ($plugins) {
                            return ($key == 'cms') || in_array($key, $plugins);
                        })
                        ->toArray();

                    return $actions;
                }
            );
    }
}
