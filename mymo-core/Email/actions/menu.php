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
 * Date: 6/5/2021
 * Time: 12:25 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('mymo_core::app.email_setting'),
    'setting.email',
    [
        'icon' => 'fa fa-cogs',
        'position' => 10,
        'parent' => 'setting',
    ]
);

HookAction::addAdminMenu(
    trans('mymo_core::app.email_templates'),
    'setting.email-template',
    [
        'icon' => 'fa fa-cogs',
        'position' => 10,
        'parent' => 'setting',
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
