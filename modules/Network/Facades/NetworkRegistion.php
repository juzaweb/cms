<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Facades;

use Illuminate\Support\Facades\Facade;
use Juzaweb\Network\Contracts\NetworkRegistionContract;

/**
 * @method static void init()
 */
class NetworkRegistion extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NetworkRegistionContract::class;
    }
}
