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
use Juzaweb\DevTool\Http\Controllers\Plugins\PluginController;
use Juzaweb\DevTool\Http\Controllers\Themes\PostTypeController;
use Juzaweb\DevTool\Http\Controllers\Themes\TaxonomyController;
use Juzaweb\DevTool\Http\Controllers\Themes\ThemeController;

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

Route::group(
    ['prefix' => 'dev-tools/themes'],
    function () {
        // Route::resource('/', ThemeController::class)
        //     ->only(['index', 'edit', 'create', 'destroy']);

        Route::get('/', [ThemeController::class, 'index']);
        Route::get('create', [ThemeController::class, 'create']);
        Route::post('/', [ThemeController::class, 'store']);
        Route::get('{name}/edit', [ThemeController::class, 'edit']);
        Route::put('{name}', [ThemeController::class, 'update']);
        Route::delete('{name}', [ThemeController::class, 'destroy']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/post-types'],
    function () {
        Route::resource('/', PostTypeController::class);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/taxonomies'],
    function () {
        Route::resource('/', TaxonomyController::class);
    }
);
