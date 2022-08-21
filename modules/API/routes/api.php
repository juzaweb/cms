<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

Route::group(
    [
        'prefix' => 'admin',
        'middleware' => ['auth:api', \Juzaweb\API\Http\Middleware\Admin::class],
    ],
    function () {
        require __DIR__ . '/admin/api.php';
    }
);

require __DIR__ . '/api/auth.php';
require __DIR__ . '/api/post.php';
require __DIR__ . '/api/user.php';
