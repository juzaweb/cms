<?php

use Juzaweb\Backend\Http\Controllers\Backend\Setting\MediaController;
use Juzaweb\Backend\Http\Controllers\Backend\Setting\SystemSettingController;

Route::group(
    ['prefix' => 'setting/system'],
    function () {
        Route::get('/', [SystemSettingController::class, 'index'])->name('admin.setting');
        Route::get('/{form}', [SystemSettingController::class, 'index'])->name('admin.setting.form');
        Route::post('/save', [SystemSettingController::class, 'save'])->name('admin.setting.save');
    }
);

Route::get('/options-media', [MediaController::class, 'index'])->name('admin.setting.media');
