<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\UpdateController;

Route::group(
    ['prefix' => 'updates'],
    function () {
        Route::get('/', [UpdateController::class, 'index'])->name('admin.update');
        Route::get('check-update', [UpdateController::class, 'checkUpdate'])->name('admin.update.check');
        Route::get('process/{type}', [UpdateController::class, 'update'])->name('admin.update.process');

        Route::get('get-plugins', [UpdateController::class, 'pluginDatatable'])->name('admin.update.plugins');
        Route::get('get-themes', [UpdateController::class, 'themeDatatable'])->name('admin.update.themes');
    }
);

Route::post('update/success', [UpdateController::class, 'updateSuccess'])
    ->name('admin.update.success');
Route::post('update/{type}/{step}', [UpdateController::class, 'updateStep'])
    ->where('step', '[0-9]+')->name('admin.update.step');

Route::post(
    'module/login-juzaweb',
    'Backend\Module\BuyModuleController@loginJuzaWeb'
)
    ->name('admin.module.login-juzaweb');

Route::get(
    'module/{module}/buy-modal',
    'Backend\Module\BuyModuleController@buyModal'
)
    ->name('admin.module.buy-modal')
    ->where('module', '[a-z]+');

Route::post(
    'module/{module}/activation-code',
    'Backend\Module\BuyModuleController@activateByCode'
)
    ->name('admin.module.activation-code')
    ->where('module', '[a-z]+');
