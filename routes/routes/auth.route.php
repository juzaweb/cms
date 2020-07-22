<?php

Route::group(['middleware' => ['web', 'guest']], function () {
    Route::get('/login', 'Frontend\Auth\LoginController@index')->name('login');
    
    Route::post('/login', 'Frontend\Auth\LoginController@login')->name('login.submit');
    
    Route::get('/register', 'Frontend\Auth\RegisterController@index')->name('register');
    
    Route::post('/register', 'Frontend\Auth\RegisterController@register')->name('register.submit');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/logout', 'Frontend\Auth\LoginController@logout')->name('logout');
});