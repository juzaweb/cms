<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Modules\AdsManagement\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\AdsManagement\Vast\Document;
use Juzaweb\Modules\AdsManagement\Vast\Factory;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;

class VideoAdController extends ThemeController
{
    public function show(Request $request, string $position): Response|Document
    {
        $id = $request->input('id');
        $video = $this->getVideoAds($position, $id);

        if ($video === null) {
            return $this->renderNoneAds();
        }

        $factory = new Factory();
        $document = $factory->create('4.1');

        $impressionUrl = route('ads.video.impression', ['id' => $video->id]);

        $ad1 = $document
            ->createInLineAdSection()
            ->setId('ad1')
            ->setAdSystem($video->name)
            ->setAdTitle($video->title)
            ->addImpression($impressionUrl, 'imp1');

        $linearCreative = $ad1
            ->createLinearCreative()
            ->setDuration(5)
            ->setId($video->id)
            ->setAdId('pre')
            ->setDuration('00:00:30')
            ->setVideoClicksClickThrough($video->url)
            ->addVideoClicksClickTracking($video->url);

        $linearCreative
            ->createMediaFile()
            ->setProgressiveDelivery()
            ->setType('video/mp4')
            ->setBitrate(2500)
            ->setUrl(upload_url($video->video));

        return response((string) $document, 200, ['Content-Type' => 'application/xml']);
    }

    protected function getVideoAds(string $position, ?string $id = null): ?VideoAds
    {
        $builder = VideoAds::where(['position' => $position, 'active' => 1]);
        if ($id) {
            $builder->where(['id' => $id]);
        } else {
            $builder->inRandomOrder();
        }

        return $builder->first();
    }

    protected function renderNoneAds()
    {
        $document = (new Factory())->create('4.1');

        return response((string) $document, 200, ['Content-Type' => 'application/xml']);
    }

    public function trackImpression(string $id): Response
    {
        VideoAds::where('id', $id)->increment('views');

        return response('', 204);
    }
}
