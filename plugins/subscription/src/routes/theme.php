<?php

use Juzaweb\Subscription\Http\Controllers\SubscriptionController;

Route::post(
    'subscription/{driver}/{package}/redirect',
    [SubscriptionController::class, 'handleRedirect']
)
    ->name('subscription.redirect')
    ->middleware('auth');

Route::get(
    'subscription/{driver}/{package}/return',
    [SubscriptionController::class, 'handleReturn']
)
    ->name('subscription.return')
    ->middleware('auth');

Route::get(
    'subscription/{driver}/{package}/cancel',
    [SubscriptionController::class, 'handleCancel']
)
    ->name('subscription.cancel');

Route::any(
    'subscription/notify/{driver}',
    [SubscriptionController::class, 'handleNotify']
);
