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
use Juzaweb\DevTool\Http\Controllers\Themes;

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

        Route::get('/', [Themes\ThemeController::class, 'index']);
        Route::get('create', [Themes\ThemeController::class, 'create']);
        Route::post('/', [Themes\ThemeController::class, 'store']);
        Route::get('{name}/edit', [Themes\ThemeController::class, 'edit']);
        Route::put('{name}', [Themes\ThemeController::class, 'update']);
        Route::delete('{name}', [Themes\ThemeController::class, 'destroy']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/post-types'],
    function () {
        Route::resource('/', Themes\PostTypeController::class);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/taxonomies'],
    function () {
        Route::resource('/', Themes\TaxonomyController::class);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/settings'],
    function () {
        Route::get('/', [Themes\SettingController::class, 'index']);
        Route::put('/', [Themes\SettingController::class, 'update']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/templates'],
    function () {
        Route::get('/', [Themes\TemplateController::class, 'index']);
        Route::put('/', [Themes\TemplateController::class, 'update']);
    }
);
