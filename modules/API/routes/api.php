<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Juzaweb\API\Http\Controllers\SettingController;
use Juzaweb\API\Http\Controllers\SidebarController;
use Juzaweb\API\Http\Middleware\Admin;

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['auth:api', Admin::class],
    ],
    function () {
        require __DIR__.'/api/admin/api.php';
    }
);

if (config('juzaweb.api.frontend.enable')) {
    require __DIR__.'/api/auth.php';
    require __DIR__.'/api/post.php';
    require __DIR__.'/api/taxonomy.php';
    require __DIR__.'/api/user.php';
    require __DIR__.'/api/menu.php';

    Route::get('setting', [SettingController::class, 'index']);
    Route::get('sidebar/{sidebar}', [SidebarController::class, 'show']);
}
