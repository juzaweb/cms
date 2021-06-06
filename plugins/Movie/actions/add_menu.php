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
 * Date: 6/6/2021
 * Time: 4:24 PM
 */

use Mymo\Core\Facades\HookAction;

HookAction::registerPostType('movies', [
    'label' => trans('movie::app.movies'),
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 10,
    'supports' => [],
]);

HookAction::registerPostType('tv-series', [
    'label' => trans('movie::app.tv_series'),
    'menu_icon' => 'fa fa-edit',
    'menu_position' => 10,
    'supports' => [],
]);
