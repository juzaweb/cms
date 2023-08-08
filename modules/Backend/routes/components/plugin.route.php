<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\Plugin\EditorController;
use Juzaweb\Backend\Http\Controllers\Backend\Plugin\PluginController;
use Juzaweb\Backend\Http\Controllers\Backend\Plugin\PluginInstallController;

Route::group(
    ['prefix' => 'plugins'],
    function () {
        Route::get('/', [PluginController::class, 'index'])->name('admin.plugin');
        Route::get('/get-data', [PluginController::class, 'getDataTable'])->name('admin.plugin.get-data');
        Route::post('/bulk-actions', [PluginController::class, 'bulkActions'])->name('admin.plugin.bulk-actions');
    }
);

Route::group(
    ['prefix' => 'plugin/install'],
    function () {
        Route::get('/', [PluginInstallController::class, 'index'])
            ->name('admin.plugin.install');
        Route::get('/all', [PluginInstallController::class, 'getData'])
            ->name('admin.plugin.install.all');
        Route::post('/upload', [PluginInstallController::class, 'upload'])
            ->name('admin.plugin.install.upload');
    }
);

Route::group(
    ['prefix' => 'plugin/editor'],
    function () {
        Route::get('/', [EditorController::class, 'index'])
            ->name('admin.plugin.editor');
        Route::get('/content', [EditorController::class, 'getFileContent'])
            ->name('admin.plugin.editor.content');
        Route::put('/', [EditorController::class, 'save'])
            ->name('admin.plugin.editor.save');
    }
);
