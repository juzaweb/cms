<?php

Route::group(['prefix' => 'account', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', 'Frontend\Account\ProfileController@index')->name('account');
    
    Route::get('/notification', 'Frontend\Account\NotificationController@index')->name('account.notification');
    
    Route::get('/change-password', 'Frontend\Account\ChangePasswordController@index')->name('account.change_password');
    
    Route::post('/change-password', 'Frontend\Account\ChangePasswordController@handle')->name('account.change_password.handle');
});