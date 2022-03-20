<?php

use Juzaweb\Multilang\Http\Controllers\LanguageController;
use Juzaweb\Multilang\Http\Controllers\SettingController;

Route::group(
    ['prefix' => 'languages'],
    function () {
        Route::get('/', [LanguageController::class, 'index']);
        Route::post('/', [LanguageController::class, 'addLanguage']);
        Route::post('toggle-default', [LanguageController::class, 'toggleDefault'])
            ->name('admin.language.toggle-default');
    }
);

Route::group(
    ['prefix' => 'multi-language/setting'],
    function () {
        Route::get('/', [SettingController::class, 'index']);
        Route::post('/', [SettingController::class, 'save']);
    }
);
