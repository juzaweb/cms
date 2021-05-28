<?php
/**
 * MYMO CMS
 *
 * @package mymocms/mymocms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/mymocms/mymocms
*/

Route::group(['prefix' => 'admin-cp', 'middleware' => ['web', 'admin']], function () {
    require __DIR__ . '/components/dashboard.route.php';
    require __DIR__ . '/components/appearance.route.php';
    require __DIR__ . '/components/setting.route.php';
    require __DIR__ . '/components/filemanager.route.php';
    require __DIR__ . '/components/post.route.php';
    require __DIR__ . '/components/comment.route.php';
    require __DIR__ . '/components/user.route.php';
    require __DIR__ . '/components/log.route.php';
});

require __DIR__ . '/installer/install.route.php';
require __DIR__ . '/installer/update.route.php';

