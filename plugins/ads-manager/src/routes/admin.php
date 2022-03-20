<?php

use Juzaweb\AdsManager\Http\Controllers\AdsManagerController;

Route::group(
    ['prefix' => 'banner-ads'],
    function () {
        Route::jwResource('/', AdsManagerController::class);
    }
);
