<?php

namespace Mymo\Core\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static addAdminMenu(string $menuTitle, $menuSlug, array $args)
 * @method static registerMenuItem(string $key, $componentClass)
 * @method static registerPostType(string $key, $args = [])
 * @method static loadActionForm(string $path)
 * @see \Mymo\Core\Helpers\HookAction
 **/
class HookAction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'mymo.hook';
    }
}
