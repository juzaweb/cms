<?php

Route::get('/admin', 'Backend\DashboardController@index')->name('admin.dashboard');

Route::get('/admin/genres', 'Backend\GenresController@index')->name('admin.genres');