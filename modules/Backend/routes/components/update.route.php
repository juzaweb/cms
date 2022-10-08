<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

Route::group(
    ['prefix' => 'updates'],
    function () {
        Route::get('/', 'Backend\UpdateController@index')->name('admin.update');
        Route::get('check-update', 'Backend\UpdateController@checkUpdate')->name('admin.update.check');
        Route::get('process/{type}', 'Backend\UpdateController@update')->name('admin.update.process');

        Route::get('get-plugins', 'Backend\UpdateController@pluginDatatable')->name('admin.update.plugins');
        Route::get('get-themes', 'Backend\UpdateController@themeDatatable')->name('admin.update.themes');
    }
);

Route::post('update/success', 'Backend\UpdateController@updateSuccess')
    ->name('admin.update.success');
Route::post('update/{type}/{step}', 'Backend\UpdateController@updateStep')
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
