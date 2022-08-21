<?php

use Juzaweb\API\Http\Controllers\Admin\GeneralController;

Route::group(
    [
        'prefix' => 'menus',
        'middleware' => 'auth:api',
    ],
    function () {
        Route::get('admin-menu', [GeneralController::class, 'adminMenu']);
    }
);
