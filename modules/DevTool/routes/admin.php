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

Route::get('dev-tools', [DevToolController::class, 'index'])->name('admin.dev-tool');
Route::get('dev-tools/module', [DevToolController::class, 'getModuleData']);
Route::get('dev-tools/plugin/{vendor}/{name}', [PluginController::class, 'index']);
Route::post('dev-tools/plugin/{vendor}/{name}/make-post-type', [PluginController::class, 'makePostType']);
