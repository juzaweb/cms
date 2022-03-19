<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Contracts\SiteRegistionContract;

/**
 * @method static \stdClass info()
 * @see \Juzaweb\Support\SiteRegistion
 */
class Site extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return SiteRegistionContract::class;
    }
}
