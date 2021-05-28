<?php

Route::group(['prefix' => 'appearance/themes'], function () {
    Route::get('/', 'Backend\Design\ThemesController@index')->name('admin.design.themes');
    
    Route::post('/save', 'Backend\Design\ThemesController@save')->name('admin.design.themes.save');
});

Route::group(['prefix' => 'appearance/menu'], function () {
    Route::get('/', 'Backend\Design\MenuController@index')->name('admin.design.menu');
    
    Route::get('/{id}', 'Backend\Design\MenuController@index')->name('admin.design.menu.id');
    
    Route::post('/add-menu', 'Backend\Design\MenuController@addMenu')->name('admin.design.menu.add');
    
    Route::post('/save', 'Backend\Design\MenuController@save')->name('admin.design.menu.save');
    
    Route::post('/get-data', 'Backend\Design\MenuController@getItems')->name('admin.design.menu.items');
});

Route::group(['prefix' => 'appearance/sliders'], function () {
    Route::get('/', 'Backend\Design\SlidersController@index')->name('admin.design.sliders');
    
    Route::get('/getdata', 'Backend\Design\SlidersController@getData')->name('admin.design.sliders.getdata');
    
    Route::get('/create', 'Backend\Design\SlidersController@form')->name('admin.design.sliders.create');
    
    Route::get('/edit/{id}', 'Backend\Design\SlidersController@form')->name('admin.design.sliders.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Design\SlidersController@save')->name('admin.design.sliders.save');
    
    Route::post('/remove', 'Backend\Design\SlidersController@remove')->name('admin.design.sliders.remove');
});

Route::group(['prefix' => 'appearance/editor'], function () {
    Route::get('/', 'Backend\Design\ThemeEditorController@index')->name('admin.design.editor');
    
    Route::post('/save', 'Backend\Design\ThemeEditorController@save')->name('admin.design.editor.save');
});