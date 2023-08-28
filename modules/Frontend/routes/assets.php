<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\Frontend\Http\Controllers\AssetController;

//Route::get('jw-styles/{lang}/langs.js', [AssetController::class, 'languageScript'])
//    ->where('lang', '[a-z]+');

$pathRegex = '[0-9a-zA-Z\/\-\.\_]+';

Route::get('jw-styles/themes/{theme}/{path}', [AssetController::class, 'assetTheme'])
    ->where('theme', '[0-9a-z\-_]+')
    ->where('path', $pathRegex);

Route::get('jw-styles/plugins/{vendor}/{plugin}/{path}', [AssetController::class, 'assetPlugin'])
    ->where('vendor', '[0-9a-z\-_]+')
    ->where('plugin', '[0-9a-z\-_]+')
    ->where('path', $pathRegex);

Route::get('storage/{path}', [AssetController::class, 'assetStorage'])
    ->where('path', $pathRegex);

Route::get('jw-styles/images/{method}/{size}/{path}', [AssetController::class, 'proxyImage'])
    ->where('size', '([0-9auto]+)x([0-9auto]+)')
    ->where('path', $pathRegex);
