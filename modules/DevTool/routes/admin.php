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

Route::get('dev-tools', [DevToolController::class, 'index'])->name('admin.dev-tool');
Route::get('dev-tools/module', [DevToolController::class, 'getModuleData']);
