<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::group([
    'middleware' => 'guest',
    'as' => 'admin.',
    'prefix' => config('juzaweb.admin_prefix'),
    'namespace' => 'Juzaweb\Http\Controllers',
], function () {
    \Juzaweb\Support\Route\Auth::routes();
});

