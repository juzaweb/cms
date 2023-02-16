<?php

Route::group(
    ['prefix' => 'menus'],
    function () {
        Route::get('{location}', [\Juzaweb\API\Http\Controllers\MenuController::class, 'show']);
    }
);
