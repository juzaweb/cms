<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 *
 * Created by JUZAWEB.
 * Date: 6/23/2021
 * Time: 10:19 AM
 */

Route::group(['prefix' => 'email'], function () {
    Route::post('/', 'Backend\EmailController@save')->name('admin.setting.email.save');

    Route::post('send-test-mail', 'Backend\EmailController@sendTestMail')->name('admin.setting.email.test-email');
});

Route::jwResource('email-template', 'Backend\EmailTemplateController');

Route::get('logs/email', 'Backend\EmailLogController@index')->name('admin.logs.email');

