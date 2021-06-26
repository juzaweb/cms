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
 * Time: 11:29 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::addAdminMenu(
    trans('mymo::app.notifications'),
    'notification',
    [
        'icon' => 'fa fa-bell',
        'position' => 100
    ]
);
