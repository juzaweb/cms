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
use Juzaweb\Modules\AdsManagement\Entities\Position;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;

class AdsRepository implements Ads
{
    protected array $positions = [];

    protected bool $videoAdsEnabled = false;

    public function position(string $key, callable $callback): void
    {
        $this->positions[$key] = $callback;
    }

    /**
     * @return Collection<int, Position>
     */
    public function positions(): Collection
    {
        return collect($this->positions)->map(
            function ($callback, $key) {
                return new Position($key, $callback());
            }
        );
    }

    public function bannerPositions(): Collection
    {
        return $this->positions()->filter(
            function (Position $position) {
                return $position->type === 'banner';
            }
        );
    }

    public function videoPositions(): Collection
    {
        return $this->positions()->filter(
            function (Position $position) {
                return $position->type === 'video';
            }
        );
    }

    public function getBanner(string $position): ?BannerAds
    {
        return BannerAds::whereFrontend()
            ->wherePosition($position)
            ->first();
    }

    public function enableVideoAds(bool $enabled = true): void
    {
        $this->videoAdsEnabled = $enabled;
    }

    public function isVideoAdsEnabled(): bool
    {
        return $this->videoAdsEnabled;
    }
}
