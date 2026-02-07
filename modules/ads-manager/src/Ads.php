<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement;

use Illuminate\Support\Collection;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;

interface Ads
{
    public function position(string $key, callable $callback): void;

    public function positions(): Collection;

    public function bannerPositions(): Collection;

    public function videoPositions(): Collection;

    public function getBanner(string $position): ?BannerAds;

    public function enableVideoAds(bool $enabled = true): void;

    public function isVideoAdsEnabled(): bool;
}
