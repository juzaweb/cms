<?php

Route::group(['prefix' => 'update', 'middleware' => ['web', 'admin']], function () {
    Route::get('/', 'Installer\UpdateController@index')->name('update');
    
    Route::post('/', 'Installer\UpdateController@update')->name('update.submit');
});