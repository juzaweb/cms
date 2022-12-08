<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package juzaweb/juzacms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://juzaweb.com/cms
 */

use Juzaweb\Backend\Http\Controllers\Backend\Appearance\EditorController;
use Juzaweb\Backend\Http\Controllers\Backend\ThemeController;
use Juzaweb\Backend\Http\Controllers\Backend\RequirePluginController;
use Juzaweb\Backend\Http\Controllers\Backend\ReadingController;
use Juzaweb\Backend\Http\Controllers\Backend\WidgetController;
use Juzaweb\Backend\Http\Controllers\Backend\MenuController;

Route::group(
    ['prefix' => 'themes'],
    function () {
        Route::get('/', 'Backend\ThemeController@index')->name('admin.themes');
        Route::get('/get-data', 'Backend\ThemeController@getDataTheme')->name('admin.themes.get-data');
        Route::get('/require-plugins', 'Backend\RequirePluginController@index')->name('admin.themes.require-plugins');
        Route::post('/bulk-actions', 'Backend\ThemeController@bulkActions')->name('admin.themes.bulk-actions');

        Route::get(
            '/require-plugins/get-data',
            'Backend\RequirePluginController@getData'
        )->name('admin.themes.require-plugins.get-data');

        Route::delete('/delete', 'Backend\ThemeController@delete')->name('admin.themes.delete');
        Route::post('/activate', 'Backend\ThemeController@activate')->name('admin.themes.activate');
    }
);

Route::group(
    ['prefix' => 'theme/install'],
    function () {
        Route::get('/', 'Backend\ThemeInstallController@index')->name('admin.theme.install');
        Route::get('all', 'Backend\ThemeInstallController@getData')->name('admin.theme.install.all');
        Route::post('upload', 'Backend\ThemeInstallController@upload')->name('admin.theme.install.upload');
    }
);

Route::group(
    ['prefix' => 'theme/setting'],
    function () {
        Route::get(
            '/',
            'Backend\Appearance\SettingController@index'
        )->name('admin.theme.setting');

        Route::post('/', 'Backend\Appearance\SettingController@save');
    }
);

Route::group(
    ['prefix' => 'reading'],
    function () {
        Route::get('/', 'Backend\ReadingController@index')->name('admin.reading');

        Route::post('/save', 'Backend\ReadingController@save')->name('admin.reading.save');
    }
);

Route::group(
    ['prefix' => 'permalinks'],
    function () {
        Route::get('/', 'Backend\PermalinkController@index')->name('admin.permalink');

        Route::post('/save', 'Backend\PermalinkController@save')->name('admin.permalink.save');
    }
);

Route::group(
    ['prefix' => 'menus'],
    function () {
        Route::get('/', 'Backend\MenuController@index')->name('admin.menu');
        Route::get('/{id}', 'Backend\MenuController@index')->name('admin.menu.id');
        Route::post('/store', 'Backend\MenuController@store')->name('admin.menu.store');
        Route::put('/{id}', 'Backend\MenuController@update')->name('admin.menu.update');
        Route::delete('/{id}', 'Backend\MenuController@destroy')->name('admin.menu.destroy');
        Route::post('/add-item', 'Backend\MenuController@addItem')->name('admin.menu.add-item');
    }
);

Route::group(
    ['prefix' => 'widgets'],
    function () {
        Route::get('/', 'Backend\WidgetController@index')->name('admin.widget');
        Route::get('/get-item', 'Backend\WidgetController@getWidgetItem')->name('admin.widget.get-item');
        Route::put('/{key}', 'Backend\WidgetController@update')->name('admin.widget.update');
        Route::get('/form/{key}', 'Backend\WidgetController@getWidgetForm')->name('admin.widget.get-form');
    }
);

Route::group(
    ['prefix' => 'theme/editor'],
    function () {
        Route::get('/{theme?}', [EditorController::class, 'index'])->name('admin.theme.editor');
        Route::get('/{theme}/content', [EditorController::class, 'getFileContent'])
            ->name('admin.theme.editor.content');
        Route::put('/{theme}', [EditorController::class, 'save'])
            ->name('admin.theme.editor.save');
    }
);
