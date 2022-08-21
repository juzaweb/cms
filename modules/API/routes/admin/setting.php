<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

use Juzaweb\API\Http\Controllers\Admin\SettingController;

Route::group(
    [
        'prefix' => 'setting',
    ],
    function () {
        Route::get('configs', [SettingController::class, 'configs']);
    }
);
