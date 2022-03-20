<?php

use Juzaweb\SocialLogin\Http\Controllers\SocialLoginController;

Route::get(
    'auth/{method}/redirect',
    [SocialLoginController::class, 'redirect']
)->name('auth.socialites.redirect');

Route::get(
    'auth/{method}/callback',
    [SocialLoginController::class, 'callback']
)->name('auth.socialites.callback');
