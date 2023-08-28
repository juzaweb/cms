<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Facades;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Facade;
use Juzaweb\CMS\Contracts\Field as FieldContract;

/**
 * @method static fieldByType($fields)
 * @method static View|Factory render(array $fields, array|Model $values = [], bool $collection = false)
 * @method static select(string|Model $label, ?string $name, ?array $options = [])
 * @method static selectUser(string|Model $label, ?string $name, ?array $options = [])
 * @method static selectTaxonomy(string|Model $label, ?string $name, ?array $options = [])
 * @method static textarea(string|Model $label, ?string $name, ?array $options = [])
 * @method static images(string|Model $label, ?string $name, ?array $options = [])
 * @method static security(string|Model $label, ?string $name, ?array $options = [])
 * @method static text(string|Model $label, ?string $name, ?array $options = [])
 * @method static editor(string|Model $label, ?string $name, ?array $options = [])
 * @method static image(string|Model $label, ?string $name, ?array $options = [])
 * @method static checkbox(string|Model $label, ?string $name, ?array $options = [])
 * @see \Juzaweb\CMS\Support\Html\Field
*/
class Field extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return FieldContract::class;
    }
}
