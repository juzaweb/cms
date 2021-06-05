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
 * Time: 5:13 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('mymo_core::app.notifications'),
    'notification',
    [
        'icon' => 'fa fa-bell',
        'position' => 100
    ]
);
