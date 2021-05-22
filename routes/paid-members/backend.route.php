<?php

Route::group(['prefix' => 'packages'], function () {
    Route::get('/', 'PaidMembers\Backend\PackageController@index')->name('admin.package');
    
    Route::get('/getdata', 'PaidMembers\Backend\PackageController@getData')->name('admin.package.getdata');
    
    Route::get('/create', 'PaidMembers\Backend\PackageController@form')->name('admin.package.create');
    
    Route::get('/edit/{id}', 'PaidMembers\Backend\PackageController@form')->name('admin.package.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'PaidMembers\Backend\PackageController@save')->name('admin.package.save');
    
    Route::post('/status', 'PaidMembers\Backend\PackageController@status')->name('admin.package.status');
    
    Route::post('/remove', 'PaidMembers\Backend\PackageController@remove')->name('admin.package.remove');
});