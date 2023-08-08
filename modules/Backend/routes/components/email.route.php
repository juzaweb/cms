<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

use Juzaweb\Backend\Http\Controllers\Backend\Email\EmailHookController;

Route::group(
    ['prefix' => 'email'],
    function () {
        Route::post('/', 'Backend\EmailController@save')->name('admin.setting.email.save');

        Route::post('send-test-mail', 'Backend\EmailController@sendTestMail')->name('admin.setting.email.test-email');
    }
);

Route::jwResource('email-template', 'Backend\EmailTemplateController');
Route::jwResource('email-hooks', EmailHookController::class);
