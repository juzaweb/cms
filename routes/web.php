<?php
Route::group(['prefix' => 'admin-cp', 'middleware' => ['web', 'admin']], function () {
    require_once __DIR__ . '/backend/backend.route.php';
});

require_once __DIR__ . '/frontend/frontend.route.php';
