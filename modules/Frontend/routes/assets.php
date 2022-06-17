<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Frontend\Http\Controllers\AssetController;

Route::get('jw-styles/themes/{theme}/{path}', [AssetController::class, 'assetTheme'])
    ->where('theme', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\/\-\.]+');

Route::get('jw-styles/plugins/{vendor}/{plugin}/{path}', [AssetController::class, 'assetPlugin'])
    ->where('vendor', '[0-9a-z]+')
    ->where('plugin', '[0-9a-z]+')
    ->where('path', '[0-9a-zA-Z\/\-\.]+');

Route::get('storage/{path}', [AssetController::class, 'assetStorage'])
    ->where('path', '[0-9a-zA-Z\/\-\.]+');
