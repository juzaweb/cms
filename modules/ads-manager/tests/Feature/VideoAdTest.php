<?php

namespace Juzaweb\Modules\AdsManagement\Tests\Feature;

use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\AdsManagement\Tests\TestCase;

class VideoAdTest extends TestCase
{
    public function test_show_video_ad_successfully()
    {
        $position = 'home_video';
        $videoAd = new VideoAds();
        $videoAd->fill([
            'name' => 'Test Video Ad',
            'title' => 'Test Video Title',
            'url' => 'https://example.com',
            'video' => 'videos/test.mp4',
            'position' => $position,
            'active' => 1,
        ]);
        $videoAd->save();

        $response = $this->get(route('ads.video.show', ['position' => $position, 'id' => $videoAd->id]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');

        $content = $response->getContent();
        $this->assertStringContainsString('Test Video Ad', $content);
        $this->assertStringContainsString('Test Video Title', $content);
        $this->assertStringContainsString(route('ads.video.impression', ['id' => $videoAd->id]), $content);
    }

    public function test_show_video_ad_returns_empty_vast_when_not_found()
    {
        $position = 'non_existent_position';

        $response = $this->get(route('ads.video.show', ['position' => $position]));

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/xml');

        $content = $response->getContent();
        // VAST empty structure usually has root element
        $this->assertStringContainsString('<VAST', $content);
        // Should not contain any Ad element if empty
        $this->assertStringNotContainsString('<Ad ', $content);
    }

    public function test_track_impression_increments_views()
    {
        $videoAd = new VideoAds();
        $videoAd->fill([
            'name' => 'Test Impression Ad',
            'title' => 'Impression Title',
            'url' => 'https://example.com',
            'video' => 'videos/impression.mp4',
            'position' => 'sidebar',
            'active' => 1,
            'views' => 0,
        ]);
        $videoAd->save();

        $response = $this->get(route('ads.video.impression', ['id' => $videoAd->id]));

        $response->assertStatus(204);

        $this->assertDatabaseHas('video_ads', [
            'id' => $videoAd->id,
            'views' => 1,
        ]);
    }

    public function test_track_impression_fails_with_invalid_uuid()
    {
        $invalidId = 'invalid-uuid';

        // This should fail route constraint
        $response = $this->get("ads/video/{$invalidId}/impression");

        $response->assertStatus(404);
    }
}
