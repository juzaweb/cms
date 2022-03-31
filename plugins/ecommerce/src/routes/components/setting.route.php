<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */
use Juzaweb\Ecommerce\Http\Controllers\Backend\SettingController;
use Juzaweb\Ecommerce\Http\Controllers\Backend\PaymentMethodController;

Route::get('/', [SettingController::class, 'index'])->name('admin.ecommerce.setting');

Route::jwResource(
    'payment-methods',
    PaymentMethodController::class,
    [
        'name' => 'payment_methods'
    ]
);
