<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Facades;

use Juzaweb\CMS\Contracts\MacroableModelContract;
use Illuminate\Support\Facades\Facade;

class MacroableModel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MacroableModelContract::class;
    }
}
