<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package juzaweb/cms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://juzaweb.com/cms
 */

use Juzaweb\Backend\Http\Controllers\Backend\Appearance\CustomizerController;
use Juzaweb\Backend\Http\Controllers\Backend\Appearance\EditorController;
use Juzaweb\Backend\Http\Controllers\Backend\Appearance\RequirePluginController;
use Juzaweb\Backend\Http\Controllers\Backend\Appearance\SettingController;
use Juzaweb\Backend\Http\Controllers\Backend\Appearance\ThemeController;
use Juzaweb\Backend\Http\Controllers\Backend\Appearance\ThemeInstallController;
use Juzaweb\Backend\Http\Controllers\Backend\MenuController;
use Juzaweb\Backend\Http\Controllers\Backend\Setting\PermalinkController;
use Juzaweb\Backend\Http\Controllers\Backend\Setting\ReadingController;
use Juzaweb\Backend\Http\Controllers\Backend\WidgetController;

Route::group(
    ['prefix' => 'themes'],
    function () {
        Route::get('/', [ThemeController::class, 'index'])->name('admin.themes');
        Route::get('/get-data', [ThemeController::class, 'getDataTheme'])->name('admin.themes.get-data');
        Route::post('/bulk-actions', [ThemeController::class, 'bulkActions'])->name('admin.themes.bulk-actions');

        Route::get('/require-plugins', [RequirePluginController::class, 'index'])->name('admin.themes.require-plugins');
        Route::get('/require-plugins/get-data', [RequirePluginController::class, 'getData'])
            ->name('admin.themes.require-plugins.get-data');

        //Route::delete('/delete', [ThemeController::class, 'delete'])->name('admin.themes.delete');
        Route::post('/activate', [ThemeController::class, 'activate'])->name('admin.themes.activate');
    }
);

Route::group(
    ['prefix' => 'theme/install'],
    function () {
        Route::get('/', [ThemeInstallController::class, 'index'])->name('admin.theme.install');
        Route::get('all', [ThemeInstallController::class, 'getData'])->name('admin.theme.install.all');
        Route::post('upload', [ThemeInstallController::class, 'upload'])->name('admin.theme.install.upload');
    }
);

Route::group(
    ['prefix' => 'theme/setting'],
    function () {
        Route::get('/', [SettingController::class, 'index'])->name('admin.theme.setting');
        Route::post('/', [SettingController::class, 'save']);
    }
);

Route::group(
    ['prefix' => 'theme/customizer'],
    function () {
        Route::get('/', [CustomizerController::class, 'index'])->name('admin.theme.customizer');
        Route::post('/', [CustomizerController::class, 'save']);
    }
);

Route::group(
    ['prefix' => 'reading'],
    function () {
        Route::get('/', [ReadingController::class, 'index'])->name('admin.reading');
        Route::post('/save', [ReadingController::class, 'save'])->name('admin.reading.save');
    }
);

Route::group(
    ['prefix' => 'permalinks'],
    function () {
        Route::get('/', [PermalinkController::class, 'index'])->name('admin.permalink');
        Route::post('/save', [PermalinkController::class, 'save'])->name('admin.permalink.save');
    }
);

Route::group(
    ['prefix' => 'menus'],
    function () {
        Route::get('/', [MenuController::class, 'index'])->name('admin.menu');
        Route::get('/{id}', [MenuController::class, 'index'])->name('admin.menu.id');
        Route::post('/store', [MenuController::class, 'store'])->name('admin.menu.store');
        Route::put('/{id}', [MenuController::class, 'update'])->name('admin.menu.update');
        Route::delete('/{id}', [MenuController::class, 'destroy'])->name('admin.menu.destroy');
        Route::post('/add-item', [MenuController::class, 'addItem'])->name('admin.menu.add-item');
    }
);

Route::group(
    ['prefix' => 'widgets'],
    function () {
        Route::get('/', [WidgetController::class, 'index'])->name('admin.widget');
        Route::get('/get-item', [WidgetController::class, 'getWidgetItem'])->name('admin.widget.get-item');
        Route::put('/{key}', [WidgetController::class, 'update'])->name('admin.widget.update');
        Route::get('/form/{key}', [WidgetController::class, 'getWidgetForm'])->name('admin.widget.get-form');
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
