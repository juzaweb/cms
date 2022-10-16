<?php

use Juzaweb\Network\Http\Controllers\SiteController;

Route::get(
    'admin-cp/token-login',
    [SiteController::class, 'loginToken']
)->name('site.create');
