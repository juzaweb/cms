<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:03 PM
 */

Route::group(['prefix' => 'logs/email'], function () {
    Route::get('/', 'Backend\Logs\EmailLogsController@index')->name('admin.logs.email');

    Route::get('/getdata', 'Backend\Logs\EmailLogsController@getData')->name('admin.logs.email.getdata');

    Route::post('/status', 'Backend\Logs\EmailLogsController@status')->name('admin.logs.email.status');

    Route::post('/remove', 'Backend\Logs\EmailLogsController@remove')->name('admin.logs.email.remove');
});
