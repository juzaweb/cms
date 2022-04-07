<?php

namespace Juzaweb\CMS\Traits;

trait CanClearModulesCache
{
    /**
     * Clear the plugins cache if it is enabled
     */
    public function clearCache()
    {
        if (config('plugin.cache.enabled') === true) {
            app('cache')->forget(config('plugin.cache.key'));
        }
    }
}
