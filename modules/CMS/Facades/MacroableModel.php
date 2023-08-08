<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\MacroableModelContract;

/**
 * @method static void addMacro(string $model, string $name, \Closure $closure)
 * @method static bool removeMacro($model, string $name)
 * @method static bool modelHasMacro($model, $name)
 * @method static array modelsThatImplement($name)
 * @method static array macrosForModel($model)
 */
class MacroableModel extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return MacroableModelContract::class;
    }
}
