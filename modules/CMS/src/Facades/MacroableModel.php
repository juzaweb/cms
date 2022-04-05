<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Facades;

use Juzaweb\Contracts\MacroableModelContract;
use Illuminate\Support\Facades\Facade;

class MacroableModel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return MacroableModelContract::class;
    }
}