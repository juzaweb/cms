<?php

Route::group(['prefix' => 'live-tvs'], function () {
    Route::get('/', 'Backend\LiveTV\LiveTvController@index')->name('admin.live-tv');
    
    Route::get('/getdata', 'Backend\LiveTV\LiveTvController@getData')->name('admin.live-tv.getdata');
    
    Route::get('/create', 'Backend\LiveTV\LiveTvController@form')->name('admin.live-tv.create');
    
    Route::get('/edit/{id}', 'Backend\LiveTV\LiveTvController@form')->name('admin.live-tv.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\LiveTV\LiveTvController@save')->name('admin.live-tv.save');
    
    Route::post('/remove', 'Backend\LiveTV\LiveTvController@remove')->name('admin.live-tv.remove');
});

Route::group(['prefix' => 'live-tv-categories'], function () {
    Route::get('/', 'Backend\LiveTV\LiveTvCategoryController@index')->name('admin.live-tv.category');
    
    Route::get('/getdata', 'Backend\LiveTV\LiveTvCategoryController@getData')->name('admin.live-tv.category.getdata');
    
    Route::get('/create', 'Backend\LiveTV\LiveTvCategoryController@form')->name('admin.live-tv.category.create');
    
    Route::get('/edit/{id}', 'Backend\LiveTV\LiveTvCategoryController@form')->name('admin.live-tv.category.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\LiveTV\LiveTvCategoryController@save')->name('admin.live-tv.category.save');
    
    Route::post('/remove', 'Backend\LiveTV\LiveTvCategoryController@remove')->name('admin.live-tv.category.remove');
});