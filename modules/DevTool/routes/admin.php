<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\DevTool\Http\Controllers\DevToolController;
use Juzaweb\DevTool\Http\Controllers\PluginController;

Route::group(
    ['prefix' => 'dev-tools'],
    function () {
        Route::get('/', [DevToolController::class, 'index'])->name('admin.dev-tool');
        Route::get('modules', [DevToolController::class, 'getModules']);
        Route::get('module', [DevToolController::class, 'getModule']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/plugins/{vendor}/{name}'],
    function () {
        Route::get('/', [PluginController::class, 'index']);
        Route::post('make-post-type', [PluginController::class, 'makePostType']);
        Route::post('make-taxonomy', [PluginController::class, 'makeTaxonomy']);
        Route::post('make-crud', [PluginController::class, 'makeCRUD']);
    }
);
