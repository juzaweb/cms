<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\OverwriteConfigContract;

/**
 * @method static void init()
 *
 * @see \Juzaweb\CMS\Support\Config\OverwriteConfig
 */
class OverwriteConfig extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return OverwriteConfigContract::class;
    }
}
