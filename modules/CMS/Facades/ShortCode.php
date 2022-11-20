<?php

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static static register(string $name, callable|string $callback)
 * @method static string compile(string $value)
 * @see \Juzaweb\CMS\Support\ShortCode\ShortCode
 */
class ShortCode extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \Juzaweb\CMS\Contracts\ShortCode::class;
    }
}
