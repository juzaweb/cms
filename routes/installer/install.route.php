<?php

Route::get('/install', 'Installer\InstallController@index')->name('install');

Route::post('/install', 'Installer\InstallController@install')->name('install.submit');

Route::post('/install/step/{step}', 'Installer\InstallController@step')->name('install.submit.step');