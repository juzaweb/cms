<?php

use Juzaweb\API\Http\Controllers\TaxonomyController;

Route::group(
    [
        'prefix' => 'taxonomy/{type}/{taxonomy}',
    ],
    function () {
        Route::get('/', [TaxonomyController::class, 'index']);
        Route::get('/{slug}', [TaxonomyController::class, 'show']);
        Route::get('/{slug}/posts', [TaxonomyController::class, 'posts']);
    }
);
