<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 5/29/2021
 * Time: 2:24 PM
 */

Route::group(['prefix' => 'plugins'], function () {
    Route::get('/', 'Backend\PluginController@index')->name('admin.plugin');

    Route::get('/get-data', 'Backend\PluginController@getDataTable')->name('admin.plugin.get-data');

    Route::post('/bulk-actions', 'Backend\PluginController@bulkActions')->name('admin.plugin.bulk-actions');
});

Route::group(['prefix' => 'plugins/install'], function () {
    Route::get('/', 'Backend\PluginController@install')->name('admin.plugin.install');

    Route::get('/all', 'Backend\PluginController@getDataPlugin')->name('admin.plugin.install.all');

    Route::post('/update', 'Backend\PluginController@update')->name('admin.plugin.install.update');
});
