<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package    mymocms/mymocms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/mymocms/mymocms
 * @license    MIT
 *
 * Created by The Anh.
 * Date: 5/30/2021
 * Time: 1:21 PM
 */

Route::group(['prefix' => 'admin-cp', 'middleware' => ['web', 'admin']], function () {
    require __DIR__ . '/components/post.route.php';
    require __DIR__ . '/components/page.route.php';
});
