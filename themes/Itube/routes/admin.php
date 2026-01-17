<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\Themes\Itube\Http\Controllers\SettingController;

Route::get('theme/settings', [SettingController::class, 'index'])
    ->name('admin.theme.itube.settings')
    ->middleware(['permission:theme.settings']);
Route::post('theme/settings', [SettingController::class, 'update'])
    ->middleware(['permission:theme.settings']);
