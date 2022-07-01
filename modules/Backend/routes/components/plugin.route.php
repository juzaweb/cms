<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

Route::group(
    ['prefix' => 'plugins'],
    function () {
        Route::get('/', 'Backend\PluginController@index')->name('admin.plugin');

        Route::get('/get-data', 'Backend\PluginController@getDataTable')->name('admin.plugin.get-data');

        Route::post('/bulk-actions', 'Backend\PluginController@bulkActions')->name('admin.plugin.bulk-actions');
    }
);

Route::group(
    ['prefix' => 'plugin/install'],
    function () {
        Route::get('/', 'Backend\PluginInstallController@index')->name('admin.plugin.install');

        Route::get('/all', 'Backend\PluginInstallController@getData')->name('admin.plugin.install.all');

        Route::post('/upload', 'Backend\PluginInstallController@upload')->name('admin.plugin.install.upload');
    }
);
