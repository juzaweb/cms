<?php

use Juzaweb\Subscription\Http\Controllers\Backend\PackageController;
use Juzaweb\Subscription\Http\Controllers\Backend\SettingController;
use Juzaweb\Subscription\Http\Controllers\Backend\SubscriptionHistoryController;

Route::get(
    'subscription/packages/modal-test',
    [PackageController::class, 'modalTest']
)->name('subscription.package.modal-test');

Route::jwResource('subscription/packages', PackageController::class);

Route::post(
    'subscription/sync/{id}',
    [PackageController::class, 'sync']
)->name('subscription.package.sync');
Route::get('subscription/setting', [SettingController::class, 'index']);
Route::post('subscription/setting', [SettingController::class, 'save']);

Route::jwResource('subscription/histories', SubscriptionHistoryController::class);
