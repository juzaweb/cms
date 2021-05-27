<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 10:05 PM
 */

namespace Mymo\Core\Helpers;

use Mymo\Core\Traits\MenuHookAction;

class HookAction
{
    use MenuHookAction;

    /**
     * Add hook actions folder
     *
     * @param string $path
     **/
    public function loadActionForm($path)
    {
        add_filters('mymo.actions', function ($items) use ($path) {
            $items[] = $path;
            return collect($items)->unique();
        });
    }
}
