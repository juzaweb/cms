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
    trans('mymo_core::app.appearance'),
    'appearance',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 40
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.themes'),
    'appearance.themes',
    [
        'icon' => 'fa fa-paint-brush',
        'position' => 1,
        'parent' => 'appearance',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.menu'),
    'appearance.menu',
    [
        'icon' => 'fa fa-list',
        'position' => 2,
        'parent' => 'appearance',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.editor'),
    'design.editor',
    [
        'icon' => 'fa fa-layout',
        'position' => 1,
        'parent' => 'design',
        'turbolinks' => false,
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.users'),
    'users',
    [
        'icon' => 'fa fa-users',
        'position' => 50
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.setting'),
    'setting',
    [
        'icon' => 'fa fa-cogs',
        'position' => 60
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.system_setting'),
    'setting.system',
    [
        'icon' => 'fa fa-cogs',
        'position' => 1,
        'parent' => 'setting',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.language'),
    'setting.language',
    [
        'icon' => 'fa fa-cogs',
        'position' => 1,
        'parent' => 'setting',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.logs'),
    'logs',
    [
        'icon' => 'fa fa-users',
        'position' => 70
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.email_logs'),
    'logs.email',
    [
        'icon' => 'fa fa-cogs',
        'position' => 1,
        'parent' => 'logs',
    ]
);
