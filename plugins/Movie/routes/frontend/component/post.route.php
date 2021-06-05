<?php

Route::get('/posts', 'Frontend\PostController@index')->name('post');

Route::get('/post/{slug}', 'Frontend\PostController@detail')->name('post.detail');

Route::post('/post/{slug}/comment', 'Frontend\CommentController@movieComment')->name('post.comment');