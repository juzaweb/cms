<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Translation\Http\Controllers\TranslationController;

Route::get('translations', [TranslationController::class, 'index'])->name('admin.translation.lang');

Route::post('translations', [TranslationController::class, 'save'])->name('admin.translation.lang.save');
