<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Frontend\Http\Controllers\AssetController;

Route::get('jw-styles/themes/{theme}/{path}', [AssetController::class, 'assetTheme'])
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\/\-\.]+');

Route::get('jw-styles/plugins/{plugin}/{path}', [AssetController::class, 'assetPlugin'])
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\/\-\.]+');

Route::get('storage/{path}', [AssetController::class, 'assetStorage'])
    ->where('path', '[0-9a-zA-Z\/\-\.]+');
