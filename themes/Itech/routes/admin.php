<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

use Juzaweb\Themes\Itech\Http\Controllers\SettingController;

Route::get('theme/settings', [SettingController::class, 'index'])->name('admin.theme.settings');
Route::post('theme/settings', [SettingController::class, 'update'])->name('admin.theme.settings.update');
