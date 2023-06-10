<?php

use Juzaweb\Multilang\Http\Controllers\LanguageController;

Route::group(
    ['prefix' => 'languages'],
    function () {
        Route::get('/', [LanguageController::class, 'index']);
        Route::post('/', [LanguageController::class, 'addLanguage']);
        Route::post('toggle-default', [LanguageController::class, 'toggleDefault'])
            ->name('admin.language.toggle-default');
    }
);
