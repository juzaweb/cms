<?php

use Juzaweb\API\Http\Controllers\GeneralController;

Route::group(
    [
        'prefix' => 'admin',
    ],
    function () {
        Route::get('menu', [GeneralController::class, 'adminMenu']);
    }
);
