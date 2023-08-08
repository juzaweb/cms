<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Api\Http\Controllers\UserController;

Route::group(
    [
        'prefix' => 'profile',
        'middleware' => 'auth:api',
    ],
    function () {
        Route::get('/', [UserController::class, 'profile']);
    }
);
