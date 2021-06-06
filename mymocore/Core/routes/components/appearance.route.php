<?php
/**
 * MYMO CMS - Free Laravel CMS
 *
 * @package mymocms/mymocms
 * @author The Anh Dang
 *
 * Developed based on Laravel Framework
 * Github: https://github.com/mymocms/mymocms
 */

Route::group(['prefix' => 'themes'], function () {
    Route::get('/', 'Backend\Design\ThemesController@index')->name('admin.design.themes');
    
    Route::post('/save', 'Backend\Design\ThemesController@save')->name('admin.design.themes.save');
});

Route::group(['prefix' => 'menu'], function () {
    Route::get('/', 'Backend\Design\MenuController@index')->name('admin.design.menu');
    
    Route::get('/{id}', 'Backend\Design\MenuController@index')->name('admin.design.menu.id');
    
    Route::post('/add-menu', 'Backend\Design\MenuController@addMenu')->name('admin.design.menu.add');
    
    Route::post('/save', 'Backend\Design\MenuController@save')->name('admin.design.menu.save');
    
    Route::post('/get-data', 'Backend\Design\MenuController@getItems')->name('admin.design.menu.items');
});

Route::group(['prefix' => 'editor'], function () {
    Route::get('/', 'Backend\Design\ThemeEditorController@index')->name('admin.design.editor');
    
    Route::post('/save', 'Backend\Design\ThemeEditorController@save')->name('admin.design.editor.save');
});