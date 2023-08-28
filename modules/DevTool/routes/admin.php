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
use Juzaweb\DevTool\Http\Controllers\Plugins;
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
    ['prefix' => 'dev-tools/plugins'],
    function () {
        Route::get('/create', [Plugins\PluginController::class, 'create']);
        Route::post('/', [Plugins\PluginController::class, 'store']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/plugins/{vendor}/{name}'],
    function () {
        Route::get('/', [Plugins\PluginController::class, 'index']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/plugins/{vendor}/{name}/post-types'],
    function () {
        Route::get('/', [Plugins\PostTypeController::class, 'index']);
        Route::post('/', [Plugins\PostTypeController::class, 'store']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/plugins/{vendor}/{name}/taxonomies'],
    function () {
        Route::get('/', [Plugins\TaxonomyController::class, 'index']);
        Route::post('/', [Plugins\TaxonomyController::class, 'store']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/plugins/{vendor}/{name}/crud'],
    function () {
        Route::get('/', [Plugins\CRUDController::class, 'index']);
        Route::post('/', [Plugins\CRUDController::class, 'store']);
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
        Route::get('/', [Themes\PostTypeController::class, 'index']);
        Route::put('/', [Themes\PostTypeController::class, 'update']);
    }
);

Route::group(
    ['prefix' => 'dev-tools/themes/{name}/taxonomies'],
    function () {
        // Route::resource('/', Themes\TaxonomyController::class);
        Route::get('create', [Themes\TaxonomyController::class, 'create']);
        Route::post('/', [Themes\TaxonomyController::class, 'store']);
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
