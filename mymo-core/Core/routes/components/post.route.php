<?php

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', 'Backend\PostsController@index')->name('admin.posts');
    
    Route::get('/getdata', 'Backend\PostsController@getData')->name('admin.posts.getdata');
    
    Route::get('/create', 'Backend\PostsController@form')->name('admin.posts.create');
    
    Route::get('/edit/{id}', 'Backend\PostsController@form')->name('admin.posts.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostsController@save')->name('admin.posts.save');
    
    Route::post('/remove', 'Backend\PostsController@remove')->name('admin.posts.remove');
});

Route::group(['prefix' => 'post-categories'], function () {
    Route::get('/', 'Backend\PostCategoriesController@index')->name('admin.post_categories');
    
    Route::get('/getdata', 'Backend\PostCategoriesController@getData')->name('admin.post_categories.getdata');
    
    Route::get('/create', 'Backend\PostCategoriesController@form')->name('admin.post_categories.create');
    
    Route::get('/edit/{id}', 'Backend\PostCategoriesController@form')->name('admin.post_categories.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostCategoriesController@save')->name('admin.post_categories.save');
    
    Route::post('/remove', 'Backend\PostCategoriesController@remove')->name('admin.post_categories.remove');
});

Route::group(['prefix' => 'comments/post'], function () {
    Route::get('/', 'Backend\PostCommentsController@index')->name('admin.post_comments');

    Route::get('/getdata', 'Backend\PostCommentsController@getData')->name('admin.post_comments.getdata');

    Route::post('/remove', 'Backend\PostCommentsController@remove')->name('admin.post_comments.remove');

    Route::post('/approve', 'Backend\PostCommentsController@approve')->name('admin.post_comments.approve');

    Route::post('/', 'Backend\PostCommentsController@publicis')->name('admin.post_comments.publicis');
});
