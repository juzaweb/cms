<?php

use Juzaweb\Modules\AdsManagement\Http\Controllers\BannerAdController;
use Juzaweb\Modules\AdsManagement\Http\Controllers\VideoAdsController;
use Juzaweb\Modules\Core\Facades\RouteResource;

RouteResource::admin('banner-ads', BannerAdController::class);
RouteResource::admin('video-ads', VideoAdsController::class);
