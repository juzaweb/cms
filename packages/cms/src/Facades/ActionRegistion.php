<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Contracts\ActionRegistionContract;

/**
 * @method static void init()
 * @method static void register(string|array $action)
 * @see \Juzaweb\Support\ActionRegistion
 */
class ActionRegistion extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return ActionRegistionContract::class;
    }
}
