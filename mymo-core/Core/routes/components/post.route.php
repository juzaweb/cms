<?php

Route::group(['prefix' => 'pages'], function () {
    Route::get('/', 'Backend\PageController@index')->name('admin.page');

    Route::get('/getdata', 'Backend\PageController@getData')->name('admin.page.getdata');

    Route::get('/create', 'Backend\PageController@form')->name('admin.page.create');

    Route::get('/edit/{id}', 'Backend\PageController@form')->name('admin.page.edit')->where('id', '[0-9]+');

    Route::post('/save', 'Backend\PageController@save')->name('admin.page.save');

    Route::post('/remove', 'Backend\PageController@remove')->name('admin.page.remove');
});

Route::group(['prefix' => 'posts'], function () {
    Route::get('/', 'Backend\PostController@index')->name('admin.post');
    
    Route::get('/getdata', 'Backend\PostController@getData')->name('admin.post.getdata');
    
    Route::get('/create', 'Backend\PostController@form')->name('admin.post.create');
    
    Route::get('/edit/{id}', 'Backend\PostController@form')->name('admin.post.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\PostController@save')->name('admin.post.save');
    
    Route::post('/remove', 'Backend\PostController@remove')->name('admin.post.remove');
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
