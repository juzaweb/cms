<?php

Route::group(['prefix' => 'comments/movie'], function () {
    Route::get('/', 'Backend\Movie\MovieCommentsController@index')->name('admin.movie_comments');
    
    Route::get('/getdata', 'Backend\Movie\MovieCommentsController@getData')->name('admin.movie_comments.getdata');
    
    Route::post('/remove', 'Backend\Movie\MovieCommentsController@remove')->name('admin.movie_comments.remove');
    
    Route::post('/approve', 'Backend\Movie\MovieCommentsController@approve')->name('admin.movie_comments.approve');
    
    Route::post('/', 'Backend\Movie\MovieCommentsController@publicis')->name('admin.movie_comments.publicis');
});

Route::group(['prefix' => 'comments/setting'], function () {
    Route::get('/', 'Backend\Setting\CommentSettingController@index')->name('admin.setting.comment');
    
    Route::post('/save', 'Backend\Setting\CommentSettingController@save')->name('admin.setting.comment.save');
});
