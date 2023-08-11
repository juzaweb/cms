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
use Juzaweb\DevTool\Http\Controllers\PostTypes\ThemePostTypeController;
use Juzaweb\DevTool\Http\Controllers\PostTypes\ThemeTaxonomyController;
use Juzaweb\DevTool\Http\Controllers\ThemeController;

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
        Route::resource('/', ThemeController::class)
            ->only(['index', 'edit', 'create', 'destroy']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/post-types'],
    function () {
        Route::resource('/', ThemePostTypeController::class);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/taxonomies'],
    function () {
        Route::resource('/', ThemeTaxonomyController::class);
    }
);
