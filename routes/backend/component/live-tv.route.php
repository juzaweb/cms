<?php

Route::group(['prefix' => 'live-tv'], function () {
    Route::get('/', 'Backend\LiveTV\LiveTvController@index')->name('admin.live-tv');
    
    Route::get('/getdata', 'Backend\LiveTV\LiveTvController@getData')->name('admin.live-tv.getdata');
    
    Route::get('/create', 'Backend\LiveTV\LiveTvController@form')->name('admin.live-tv.create');
    
    Route::get('/edit/{id}', 'Backend\LiveTV\LiveTvController@form')->name('admin.live-tv.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\LiveTV\LiveTvController@save')->name('admin.live-tv.save');
    
    Route::post('/publish', 'Backend\LiveTV\LiveTvController@publish')->name('admin.live-tv.publish');
    
    Route::post('/remove', 'Backend\LiveTV\LiveTvController@remove')->name('admin.live-tv.remove');
});

Route::group(['prefix' => 'live-categories'], function () {
    Route::get('/', 'Backend\LiveTV\LiveTvCategoryController@index')->name('admin.live-tv.category');
    
    Route::get('/getdata', 'Backend\LiveTV\LiveTvCategoryController@getData')->name('admin.live-tv.category.getdata');
    
    Route::get('/create', 'Backend\LiveTV\LiveTvCategoryController@form')->name('admin.live-tv.category.create');
    
    Route::get('/edit/{id}', 'Backend\LiveTV\LiveTvCategoryController@form')->name('admin.live-tv.category.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\LiveTV\LiveTvCategoryController@save')->name('admin.live-tv.category.save');
    
    Route::post('/publish', 'Backend\LiveTV\LiveTvCategoryController@publish')->name('admin.live-tv.category.publish');
    
    Route::post('/remove', 'Backend\LiveTV\LiveTvCategoryController@remove')->name('admin.live-tv.category.remove');
});

Route::group(['prefix' => 'live-tv-stream/{live_tv_id}'], function () {
    Route::get('/', 'Backend\LiveTV\LiveTvStreamController@index')->name('admin.live-tv.stream');
    
    Route::get('/getdata', 'Backend\LiveTV\LiveTvStreamController@getData')->name('admin.live-tv.stream.getdata');
    
    Route::get('/create', 'Backend\LiveTV\LiveTvStreamController@form')->name('admin.live-tv.stream.create');
    
    Route::get('/edit/{id}', 'Backend\LiveTV\LiveTvStreamController@form')->name('admin.live-tv.stream.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\LiveTV\LiveTvStreamController@save')->name('admin.live-tv.stream.save');
    
    Route::post('/remove', 'Backend\LiveTV\LiveTvStreamController@remove')->name('admin.live-tv.stream.remove');
});