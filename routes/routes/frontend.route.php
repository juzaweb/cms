<?php

Route::get('/login', 'Backend\DashboardController@index')->name('login');

Route::get('/', 'Frontend\HomeController@index')->name('home');
