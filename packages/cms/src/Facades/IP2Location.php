<?php

namespace Juzaweb\Facades;

use Illuminate\Support\Facades\Facade;

class IP2Location extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ip2location';
    }
}
