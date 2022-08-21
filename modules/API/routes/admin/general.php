<?php

use Juzaweb\API\Http\Controllers\Admin\GeneralController;

Route::group(
    [
        'prefix' => 'menus',
    ],
    function () {
        Route::get('admin-menu', [GeneralController::class, 'adminMenu']);
    }
);
