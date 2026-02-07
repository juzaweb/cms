<?php

use Juzaweb\Modules\AdsManagement\Http\Controllers\Frontend\VideoAdController;

Route::get('ads/video/{position}', [VideoAdController::class, 'show'])
    ->name('ads.video.show');

Route::get('ads/video/{id}/impression', [VideoAdController::class, 'trackImpression'])
    ->name('ads.video.impression')
    ->where('id', '[0-9a-fA-F]{8}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{4}-[0-9a-fA-F]{12}');
