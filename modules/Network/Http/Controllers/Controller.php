<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Network\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\Controller as BaseController;
use Juzaweb\CMS\Traits\ResponseMessage;

class Controller extends BaseController
{
    use ResponseMessage;

    protected function addBreadcrumb(array $item, $name = 'admin')
    {
        add_filters(
            $name . '_breadcrumb',
            function ($items) use ($item) {
                $items[] = $item;

                return $items;
            }
        );
    }
}
