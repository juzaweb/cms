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
 * Time: 11:25 PM
 */

HookAction::addAdminMenu(
    trans('mymo::app.plugins'),
    'plugins',
    [
        'icon' => 'fa fa-plug',
        'position' => 50
    ]
);
