<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/26/2021
 * Time: 9:18 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('mymo_core::app.dashboard'),
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1
    ]
);

HookAction::addAdminMenu(
    'mymo_core::app.dashboard',
    'dashboard',
    [
        'icon' => 'fa fa-dashboard',
        'position' => 1,
        'parent' => 'dashboard',
    ]
);

HookAction::addAdminMenu(
    'mymo_core::app.updates',
    'updates',
    [
        'icon' => 'fa fa-upgrade',
        'position' => 2,
        'parent' => 'dashboard',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.users'),
    'users',
    [
        'icon' => 'fa fa-users',
        'position' => 60
    ]
);
