<?php

use Juzaweb\API\Http\Controllers\Documentation\SwaggerController;

Route::group(
    [
        'prefix' => 'api/documentation',
    ],
    function () {
        Route::get('/', [SwaggerController::class, 'index']);
    }
);
