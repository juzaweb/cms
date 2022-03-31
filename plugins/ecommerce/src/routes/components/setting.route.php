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
use Juzaweb\Ecommerce\Http\Controllers\Backend\InventoryController;
use Juzaweb\Ecommerce\Http\Controllers\Backend\VariantController;

Route::get('settings', [SettingController::class, 'index'])->name('admin.ecommerce.setting');

Route::jwResource(
    'variants',
    VariantController::class,
    [
        'name' => 'variants'
    ]
);

Route::jwResource(
    'payment-methods',
    PaymentMethodController::class,
    [
        'name' => 'payment_methods'
    ]
);

Route::jwResource(
    'inventories',
    InventoryController::class,
    [
        'name' => 'inventories'
    ]
);
