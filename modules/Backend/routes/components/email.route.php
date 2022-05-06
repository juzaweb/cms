<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzaweb/juzacms
 * @license    MIT
 */

Route::group(
    ['prefix' => 'email'],
    function () {
        Route::post('/', 'Backend\EmailController@save')->name('admin.setting.email.save');

        Route::post('send-test-mail', 'Backend\EmailController@sendTestMail')->name('admin.setting.email.test-email');
    }
);

Route::jwResource('email-template', 'Backend\EmailTemplateController');

Route::get(
    'logs/email',
    'Backend\EmailLogController@index'
)->name('admin.logs.email');
