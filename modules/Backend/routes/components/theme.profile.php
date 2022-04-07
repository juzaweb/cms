<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Backend\Http\Controllers\Frontend\ProfileController;

Route::group(
    [
        'middleware' => 'auth',
        'prefix' => 'profile'
    ],
    function () {
        Route::get('notification', [ProfileController::class, 'notification'])
            ->name('profile.notification');
        Route::get('change-password', [ProfileController::class, 'changePassword'])
            ->name('profile.change_password');
        Route::post('change-password', [ProfileController::class, 'doChangePassword']);
        Route::get('/{slug?}', [ProfileController::class, 'index'])
            ->name('profile');
    }
);
