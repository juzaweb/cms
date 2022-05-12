<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

use Juzaweb\Frontend\Http\Controllers\AssetController;

Route::get('themes/{theme}/{path}', [AssetController::class, 'assetsTheme'])
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\/\-\.]+');
/*
Route::get('jw-styles/plugins/{plugin}/{path}', 'Frontend\AssetController@assetsPlugin')
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-z\.\/\-]+');

Route::get('storage/{path}', 'Frontend\AssetController@assetsStorage')
    ->where('path', '[0-9a-z\.\/\-]+');*/
