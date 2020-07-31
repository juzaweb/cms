<?php

Route::group(['middleware' => ['web', 'guest']], function () {
    Route::get('/login', 'Frontend\Auth\LoginController@index')->name('login');
    
    Route::post('/login', 'Frontend\Auth\LoginController@login')->name('login.submit');
    
    Route::get('/register', 'Frontend\Auth\RegisterController@index')->name('register');
    
    Route::post('/register', 'Frontend\Auth\RegisterController@register')->name('register.submit');
    
    Route::post('/forgot-password', 'Frontend\Auth\ForgotPasswordController@handle')->name('password.forgot.submit');
    
    Route::get('/reset-password/{token}', 'Frontend\Auth\ResetPasswordController@index')->name('password.reset');
    
    Route::post('/reset-password/{token}', 'Frontend\Auth\ResetPasswordController@handle')->name('password.reset.submit');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/logout', 'Frontend\Auth\LoginController@logout')->name('logout');
});