<?php

Route::group(['prefix' => 'setting/system'], function () {
    Route::get('/', 'Backend\Setting\SystemSettingController@index')->name('admin.setting');
    
    Route::get('/{form}', 'Backend\Setting\SystemSettingController@index')->name('admin.setting.form');
    
    Route::post('/save', 'Backend\Setting\SystemSettingController@save')->name('admin.setting.save');
    
    Route::post('/block-ip', 'Backend\Setting\SystemSettingController@saveBlockIp')->name('admin.setting.save.block_ip');
});

Route::group(['prefix' => 'setting/language'], function () {
    Route::get('/', 'Backend\Setting\LanguageController@index')->name('admin.setting.languages');
    
    Route::get('/getdata', 'Backend\Setting\LanguageController@getData')->name('admin.setting.languages.getdata');
    
    Route::post('/save', 'Backend\Setting\LanguageController@save')->name('admin.setting.languages.save');
    
    Route::post('/remove', 'Backend\Setting\LanguageController@remove')->name('admin.setting.languages.remove');
    
    Route::post('/sync', 'Backend\Setting\LanguageController@syncLanguage')->name('admin.setting.languages.sync');
    
    Route::post('/set-default', 'Backend\Setting\LanguageController@setDefault')->name('admin.setting.languages.default');
});

Route::group(['prefix' => 'setting/translate'], function () {
    Route::get('/{lang}', 'Backend\Setting\TranslateController@index')->name('admin.setting.translate')->where('lang', '[a-z]+');
    
    Route::get('/{lang}/getdata', 'Backend\Setting\TranslateController@getData')->name('admin.setting.translate.getdata')->where('lang', '[a-z]+');
    
    Route::post('/{lang}/save', 'Backend\Setting\TranslateController@save')->name('admin.setting.translate.save')->where('lang', '[a-z]+');
});

Route::group(['prefix' => 'setting/ads'], function () {
    Route::get('/', 'Backend\Setting\AdsSettingController@index')->name('admin.setting.ads');
    
    Route::get('/getdata', 'Backend\Setting\AdsSettingController@getData')->name('admin.setting.ads.getdata');
    
    Route::get('/edit/{id}', 'Backend\Setting\AdsSettingController@form')->name('admin.setting.ads.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\AdsSettingController@save')->name('admin.setting.ads.save');
});

Route::group(['prefix' => 'setting/video-ads'], function () {
    Route::get('/', 'Backend\Setting\VideoAdsController@index')->name('admin.setting.video_ads');
    
    Route::get('/getdata', 'Backend\Setting\VideoAdsController@getData')->name('admin.setting.video_ads.getdata');
    
    Route::get('/create', 'Backend\Setting\VideoAdsController@form')->name('admin.setting.video_ads.create');
    
    Route::get('/edit/{id}', 'Backend\Setting\VideoAdsController@form')->name('admin.setting.video_ads.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\VideoAdsController@save')->name('admin.setting.video_ads.save');
    
    Route::post('/remove', 'Backend\Setting\VideoAdsController@remove')->name('admin.setting.video_ads.remove');
});

Route::group(['prefix' => 'setting/seo'], function () {
    Route::get('/', 'Backend\Setting\SeoSettingController@index')->name('admin.setting.seo');
    
    Route::post('/save', 'Backend\Setting\SeoSettingController@save')->name('admin.setting.seo.save');
});