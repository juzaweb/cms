<?php

Route::group(['prefix' => 'setting/system'], function () {
    Route::get('/', 'Backend\Setting\SystemSettingController@index')->name('admin.setting');

    Route::get('/{form}', 'Backend\Setting\SystemSettingController@index')->name('admin.setting.form');

    Route::post('/save', 'Backend\Setting\SystemSettingController@save')->name('admin.setting.save');
});
