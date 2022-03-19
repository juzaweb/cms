<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Support\Route;

use Illuminate\Support\Facades\Route;
use Juzaweb\Backend\Http\Controllers\Auth\LoginController;
use Juzaweb\Backend\Http\Controllers\Auth\RegisterController;
use Juzaweb\Backend\Http\Controllers\Auth\ForgotPasswordController;
use Juzaweb\Backend\Http\Controllers\Auth\ResetPasswordController;

class Auth
{
    public static function routes()
    {
        Route::group([
            'middleware' => 'guest',
        ], function () {
            Route::get('login', [LoginController::class, 'index'])->name('login');
            Route::post('login', [LoginController::class, 'login']);

            Route::get('register', [RegisterController::class, 'index'])->name('register');
            Route::post('register', [RegisterController::class, 'register']);

            Route::get('forgot-password', [ForgotPasswordController::class, 'index'])->name('forgot_password');
            Route::post('forgot-password', [ForgotPasswordController::class, 'forgotPassword']);

            Route::get('reset-password', [ResetPasswordController::class, 'index'])->name('reset_password');
            Route::post('reset-password', [ResetPasswordController::class, 'resetPassword']);

            Route::get(
                'verification/{email}/{token}',
                [RegisterController::class, 'verification']
            )->name('verification');
        });

        Route::group(['middleware' => 'auth'], function () {
            Route::post('logout', [LoginController::class, 'logout'])->name('logout');
        });
    }
}
