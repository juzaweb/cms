<?php

use Juzaweb\API\Http\Controllers\Admin\GeneralController;

Route::group(
    [
        //'prefix' => 'menus',
    ],
    function () {
        Route::get('menu-left', [GeneralController::class, 'adminMenu']);
    }
);
