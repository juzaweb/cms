<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

Route::group([
    'middleware' => 'guest',
    'as' => 'admin.',
    'prefix' => config('juzaweb.admin_prefix'),
    'namespace' => 'Juzaweb\CMS\Http\Controllers',
], function () {
    \Juzaweb\CMS\Support\Route\Auth::routes();
});

