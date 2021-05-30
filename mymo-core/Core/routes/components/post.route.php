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

Route::mymoResource('posts', 'Backend\PostController');

Route::mymoResource('post/categories', 'Backend\PostCategoriesController');

Route::group(['prefix' => 'comments/post'], function () {
    Route::get('/', 'Backend\PostCommentsController@index')->name('admin.post_comments');

    Route::get('/getdata', 'Backend\PostCommentsController@getData')->name('admin.post_comments.getdata');

    Route::post('/remove', 'Backend\PostCommentsController@remove')->name('admin.post_comments.remove');

    Route::post('/approve', 'Backend\PostCommentsController@approve')->name('admin.post_comments.approve');

    Route::post('/', 'Backend\PostCommentsController@publicis')->name('admin.post_comments.publicis');
});
