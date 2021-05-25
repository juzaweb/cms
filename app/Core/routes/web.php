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
    require_once __DIR__ . '/components/design.route.php';
    require_once __DIR__ . '/components/setting.route.php';
    require_once __DIR__ . '/components/filemanager.route.php';
    require_once __DIR__ . '/components/post.route.php';
    require_once __DIR__ . '/components/comment.route.php';
});

require_once __DIR__ . '/installer/install.route.php';
require_once __DIR__ . '/installer/update.route.php';

