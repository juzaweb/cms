<?php
Route::group(['prefix' => 'admin', 'middleware' => ['web', 'admin']], function () {
    require_once __DIR__ . '/routes/backend.route.php';
});

require_once __DIR__ . '/routes/frontend.route.php';
