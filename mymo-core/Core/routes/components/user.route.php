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

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'Backend\UsersController@index')->name('admin.users');

    Route::get('/getdata', 'Backend\UsersController@getData')->name('admin.users.getdata');

    Route::get('/create', 'Backend\UsersController@form')->name('admin.users.create');

    Route::get('/edit/{id}', 'Backend\UsersController@form')->name('admin.users.edit')->where('id', '[0-9]+');

    Route::post('/save', 'Backend\UsersController@save')->name('admin.users.save');

    Route::post('/remove', 'Backend\UsersController@remove')->name('admin.users.remove');
});
