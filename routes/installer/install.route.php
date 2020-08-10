<?php

Route::get('/install', 'Installer\InstallController@index')->name('install');

Route::post('/install', 'Installer\InstallController@install')->name('install.submit');