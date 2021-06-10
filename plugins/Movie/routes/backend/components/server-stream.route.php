<?php

Route::group(['prefix' => 'server-stream'], function () {
    Route::get('/', 'Backend\ServerStreamController@index')->name('admin.server-stream');
    
    Route::get('/getdata', 'Backend\ServerStreamController@getData')->name('admin.server-stream.getdata');
    
    Route::get('/create', 'Backend\ServerStreamController@form')->name('admin.server-stream.create');
    
    Route::get('/edit/{id}', 'Backend\ServerStreamController@form')->name('admin.server-stream.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\ServerStreamController@save')->name('admin.server-stream.save');
    
    Route::post('/publish', 'Backend\ServerStreamController@publish')->name('admin.server-stream.publish');
    
    Route::post('/remove', 'Backend\ServerStreamController@remove')->name('admin.server-stream.remove');
});