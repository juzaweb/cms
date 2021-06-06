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
 * Date: 5/30/2021
 * Time: 12:08 PM
 */

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', 'PageController@index')->name('admin.page.index');

    Route::get('/getdata', 'PageController@getData')->name('admin.page.getdata');

    Route::get('/create', 'PageController@form')->name('admin.page.create');

    Route::get('/edit/{id}', 'PageController@form')->name('admin.page.edit')->where('id', '[0-9]+');

    Route::post('/save', 'PageController@save')->name('admin.page.save');

    Route::post('/bulk-actions', 'PageController@bulkActions')->name('admin.page.bulk-actions');
});
