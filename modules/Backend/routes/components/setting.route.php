<?php

use Juzaweb\Backend\Http\Controllers\Backend\Setting\SeoController;
use Juzaweb\Backend\Http\Controllers\Backend\Setting\SystemSettingController;

Route::group(
    ['prefix' => 'setting/system'],
    function () {
        Route::get('/', [SystemSettingController::class, 'index'])->name('admin.setting');
        Route::get('/{form}', [SystemSettingController::class, 'index'])->name('admin.setting.form');
        Route::post('/save', [SystemSettingController::class, 'save'])->name('admin.setting.save');
    }
);

Route::group(
    ['prefix' => 'setting/seo'],
    function () {
        Route::get('/', [SeoController::class, 'index'])->name('admin.setting.seo');
    }
);
