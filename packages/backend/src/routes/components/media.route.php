<?php

Route::group(['prefix' => 'media'], function () {
    Route::get('/', 'Backend\MediaController@index')->name('admin.media.index');

    Route::get('/folder/{folder}', 'Backend\MediaController@index')->name('admin.media.folder')->where('folder', '[0-9]+');

    Route::post('/add-folder', 'Backend\MediaController@addFolder')->name('admin.media.add-folder');
});
