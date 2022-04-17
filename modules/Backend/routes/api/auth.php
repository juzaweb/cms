<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Backend\Http\Controllers\API\Auth\LoginController;

Route::group(
    ['prefix' => 'auth'],
    function () {
        Route::post('login', [LoginController::class, 'login']);
    }
);
