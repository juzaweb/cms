<?php

Route::group(['prefix' => 'account', 'middleware' => ['web', 'auth']], function () {
    Route::get('/', 'Frontend\Account\ProfileController@index')->name('account');
    
    Route::get('/notification', 'Frontend\Account\NotificationController@index')->name('account.notification');
    
    Route::get('/notification/{id}', 'Frontend\Account\NotificationController@detail')->name('account.notification.detail');
    
    Route::get('/change-password', 'Frontend\Account\ChangePasswordController@index')->name('account.change_password');
    
    Route::post('/change-password', 'Frontend\Account\ChangePasswordController@handle')->name('account.change_password.handle');
});

Route::get('account/get-notifications', 'Frontend\Account\NotificationController@getUnreadNotifications')->name('account.notifications');

Route::post('account/get-notifications', 'Frontend\Account\NotificationController@readAllNotifications')->name('account.notifications.read_all');