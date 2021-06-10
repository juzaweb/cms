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
 * Time: 11:36 AM
 */

Route::group([
    'prefix' => config('mymo_core.admin_prefix'),
    'middleware' => ['web', 'admin']
], function (){
    Route::mymoResource('notification', 'NotificationController');
});
