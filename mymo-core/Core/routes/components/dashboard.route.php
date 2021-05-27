<?php
/**
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/25/2021
 * Time: 9:00 PM
 */

Route::group(['prefix' => '/'], function () {
    Route::get('/', 'Backend\DashboardController@index');

    Route::get('/dashboard', 'Backend\DashboardController@dashboard')->name('admin.dashboard');

    Route::get('/load-data/{func}', 'Backend\LoadDataController@loadData')->name('admin.load_data');

    Route::get('/dashboard/users', 'Backend\DashboardController@getDataUser')->name('admin.dashboard.users');

    Route::get('/dashboard/notifications', 'Backend\DashboardController@getDataNotification')->name('admin.dashboard.notifications');

    Route::get('/dashboard/views-chart', 'Backend\DashboardController@viewsChart')->name('admin.dashboard.views_chart');
});