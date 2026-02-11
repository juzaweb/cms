<?php

namespace Juzaweb\Modules\AdsManagement\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Juzaweb\Modules\AdsManagement\Ads;
use Juzaweb\Modules\AdsManagement\Models\VideoAds;
use Juzaweb\Modules\AdsManagement\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;

class VideoAdsTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create(['is_super_admin' => 1]);
        Auth::login($this->user);
    }

    public function test_index()
    {
        $response = $this->get(route('admin.video-ads.index'));

        $response->assertStatus(200);
    }

    public function test_create()
    {
        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('videoPositions')->andReturn(collect([
                (object) ['name' => 'Video Mid', 'key' => 'video_mid'],
            ]));
        });

        $response = $this->get(route('admin.video-ads.create'));

        $response->assertStatus(200);
    }

    public function test_store()
    {
        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('videoPositions')->andReturn(collect([
                (object) ['name' => 'Video Mid', 'key' => 'video_mid'],
            ]));
        });

        $response = $this->post(route('admin.video-ads.store'), [
            'name' => 'Test Video Ad',
            'title' => 'Test Title',
            'url' => 'https://example.com',
            'video' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'position' => 'video_mid',
            'offset' => 10,
            'active' => 1,
        ]);

        $response->assertRedirect(route('admin.video-ads.index'));

        $this->assertDatabaseHas('video_ads', ['name' => 'Test Video Ad']);
    }

    public function test_edit()
    {
        $videoAd = VideoAds::factory()->create();

        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('videoPositions')->andReturn(collect([
                (object) ['name' => 'Video Mid', 'key' => 'video_mid'],
            ]));
        });

        $response = $this->get(route('admin.video-ads.edit', [$videoAd->id]));

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $videoAd = VideoAds::factory()->create();

        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('videoPositions')->andReturn(collect([
                (object) ['name' => 'Video Mid', 'key' => 'video_mid'],
            ]));
        });

        $response = $this->put(route('admin.video-ads.update', [$videoAd->id]), [
            'name' => 'Updated Video Ad',
            'title' => 'Updated Title',
            'url' => 'https://updated.com',
            'video' => 'https://updated.com/video.mp4',
            'position' => 'video_mid',
            'offset' => 20,
            'active' => 1,
        ]);

        $response->assertRedirect(route('admin.video-ads.index'));

        $this->assertDatabaseHas('video_ads', ['id' => $videoAd->id, 'name' => 'Updated Video Ad']);
    }

    public function test_bulk_delete()
    {
        $videoAds = VideoAds::factory(3)->create();
        $ids = $videoAds->pluck('id')->toArray();

        $response = $this->postJson(route('admin.video-ads.bulk'), [
            'action' => 'delete',
            'ids' => $ids,
        ]);

        $response->assertStatus(200);

        foreach ($ids as $id) {
            $this->assertDatabaseMissing('video_ads', ['id' => $id]);
        }
    }
}
