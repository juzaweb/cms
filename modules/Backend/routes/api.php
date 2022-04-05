<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 8/12/2021
 * Time: 4:03 PM
 */

use Juzaweb\Http\Controllers\Api\PostController;

Route::group([
    'prefix' => 'auth',
], function () {
    Route::post('login', 'Api\Auth\LoginController@login');

    Route::post('refresh', 'Api\Auth\LoginController@refresh');

    Route::post('logout', 'Api\Auth\LoginController@logout');
    //Route::post('profile', 'Auth\LoginController@profile');
});

//Route::apiResource('post-type/{type}', '\\' . PostController::class);
