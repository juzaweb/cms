<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\EventyContract;

class Eventy extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return EventyContract::class;
    }
}
