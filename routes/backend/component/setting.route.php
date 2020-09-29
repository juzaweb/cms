<?php

Route::group(['prefix' => 'setting/system'], function () {
    Route::get('/', 'Backend\Setting\SystemSettingController@index')->name('admin.setting');
    
    Route::post('/save', 'Backend\Setting\SystemSettingController@save')->name('admin.setting.save');
    
    Route::get('/get-form', 'Backend\Setting\SystemSettingController@getSettingForm')->name('admin.setting.form');
});

Route::group(['prefix' => 'setting/email'], function () {
    Route::get('/', 'Backend\Setting\EmailSettingController@index')->name('admin.setting.email');
    
    Route::post('/save', 'Backend\Setting\EmailSettingController@save')->name('admin.setting.email.save');
    
    Route::post('/test', 'Backend\Setting\EmailSettingController@sendEmailTest')->name('admin.setting.email.test');
});

Route::group(['prefix' => 'setting/email-templates'], function () {
    Route::get('/', 'Backend\Setting\EmailTemplateController@index')->name('admin.setting.email_templates');
    
    Route::get('/getdata', 'Backend\Setting\EmailTemplateController@getData')->name('admin.setting.email_templates.getdata');
    
    Route::get('/edit/{id}', 'Backend\Setting\EmailTemplateController@form')->name('admin.setting.email_templates.edit')->where('id', '[0-9]+');
    
    Route::post('/save', 'Backend\Setting\EmailTemplateController@save')->name('admin.setting.email_templates.save');
    
    Route::get('/edit-layout', 'Backend\Setting\EmailTemplateController@editLayout')->name('admin.setting.email_templates.edit_layout');
    
    Route::post('/edit-layout', 'Backend\Setting\EmailTemplateController@saveLayout')->name('admin.setting.email_templates.edit_layout.save');
});

Route::group(['prefix' => 'setting/languages'], function () {
    Route::get('/', 'Backend\Setting\LanguagesController@index')->name('admin.setting.languages');
    
    Route::get('/getdata', 'Backend\Setting\LanguagesController@getData')->name('admin.setting.languages.getdata');
    
    Route::post('/save', 'Backend\Setting\LanguagesController@save')->name('admin.setting.languages.save');
    
    Route::post('/remove', 'Backend\Setting\LanguagesController@remove')->name('admin.setting.languages.remove');
    
    Route::post('/sync', 'Backend\Setting\LanguagesController@syncLanguage')->name('admin.setting.languages.sync');
    
    Route::post('/set-default', 'Backend\Setting\LanguagesController@setDefault')->name('admin.setting.languages.default');
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