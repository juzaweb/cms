<?php

Route::get('/uploads/{path}', 'Frontend\StreamController@image')->name('stream.image')->where('path', '(.*)');

Route::get('/videos/{token}/{file}/{file_name}', 'Frontend\StreamController@video')->name('stream.video');

Route::get('/stream/{file}/{quality}/{file_name}', 'Frontend\Stream\StreamController@stream')->name('stream.service');