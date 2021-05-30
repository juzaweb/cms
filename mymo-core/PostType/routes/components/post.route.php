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
 * Time: 12:08 PM
 */

Route::mymoResource('posts', 'PostController');

Route::mymoResource('post/categories', 'PostCategoriesController');

Route::group(['prefix' => 'comments/post'], function () {
    Route::get('/', 'PostCommentsController@index')->name('admin.post_comments');

    Route::get('/getdata', 'PostCommentsController@getData')->name('admin.post_comments.getdata');

    Route::post('/remove', 'PostCommentsController@remove')->name('admin.post_comments.remove');

    Route::post('/approve', 'PostCommentsController@approve')->name('admin.post_comments.approve');

    Route::post('/', 'PostCommentsController@publicis')->name('admin.post_comments.publicis');
});
