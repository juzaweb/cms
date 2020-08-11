<?php

Route::get('/update', 'Installer\UpdateController@index')->name('update');

Route::post('/update', 'Installer\UpdateController@update')->name('update.submit');