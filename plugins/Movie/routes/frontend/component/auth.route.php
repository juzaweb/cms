<?php

Route::group(['prefix' => 'login', 'middleware' => ['web', 'guest']], function () {
    Route::get('/', 'Frontend\Auth\LoginController@index')->name('login');
    
    Route::post('/', 'Frontend\Auth\LoginController@login')->name('login.submit');
});

Route::group(['prefix' => 'register', 'middleware' => ['web', 'guest']], function () {
    Route::get('/', 'Frontend\Auth\RegisterController@index')->name('register');
    
    Route::post('/', 'Frontend\Auth\RegisterController@register')->name('register.submit');
    
    Route::get('/verification/{token}', 'Frontend\Auth\VerificationController@index')->name('register.verification');
});

Route::group(['prefix' => 'forgot-password', 'middleware' => ['web', 'guest']], function () {
    Route::post('/', 'Frontend\Auth\ForgotPasswordController@handle')->name('password.forgot.submit');
    
    Route::get('/success', 'Frontend\Auth\ForgotPasswordController@message')->name('password.forgot.success');
});

Route::group(['prefix' => 'reset-password', 'middleware' => ['web', 'guest']], function () {
    Route::get('/{token}', 'Frontend\Auth\ResetPasswordController@index')->name('password.reset');
    
    Route::post('/{token}', 'Frontend\Auth\ResetPasswordController@handle')->name('password.reset.submit');
});

Route::group(['middleware' => ['web', 'auth']], function () {
    Route::get('/user/logout', 'Frontend\Auth\LoginController@logout')->name('logout');
});