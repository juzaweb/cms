<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/juzacms
 * @license    GNU V2
 */

Route::group(
    ['prefix' => 'email'],
    function () {
        Route::post('/', 'Backend\EmailController@save')->name('admin.setting.email.save');

        Route::post('send-test-mail', 'Backend\EmailController@sendTestMail')->name('admin.setting.email.test-email');
    }
);

Route::jwResource('email-template', 'Backend\EmailTemplateController');
