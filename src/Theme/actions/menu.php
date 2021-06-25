<?php
/**
 * MYMO CMS - The Best Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 6/25/2021
 * Time: 11:27 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('mymo::app.themes'),
    'themes',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 1,
        'parent' => 'appearance',
    ]
);
