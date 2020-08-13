<?php

Route::group(['prefix' => 'admin-cp', 'middleware' => ['web', 'admin']], function () {
    Route::get('/update', 'Installer\UpdateController@index')->name('update');
    
    Route::post('/update', 'Installer\UpdateController@update')->name('update.submit');
});