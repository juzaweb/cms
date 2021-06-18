<?php

namespace Mymo\Plugin\Traits;

trait CanClearModulesCache
{
    /**
     * Clear the plugins cache if it is enabled
     */
    public function clearCache()
    {
        if (config('modules.cache.enabled') === true) {
            app('cache')->forget(config('modules.cache.key'));
        }
    }
}
