<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:02 PM
 */

Route::group(['prefix' => 'notification'], function () {
    Route::get('/', 'Backend\SendNotificationController@index')->name('admin.notification');

    Route::get('/getdata', 'Backend\SendNotificationController@getData')->name('admin.notification.getdata');

    Route::get('/create', 'Backend\SendNotificationController@form')->name('admin.notification.create');

    Route::get('/edit/{id}', 'Backend\SendNotificationController@form')->name('admin.notification.edit')->where('id', '[0-9]+');

    Route::post('/save', 'Backend\SendNotificationController@save')->name('admin.notification.save');

    Route::post('/remove', 'Backend\SendNotificationController@remove')->name('admin.notification.remove');
});
