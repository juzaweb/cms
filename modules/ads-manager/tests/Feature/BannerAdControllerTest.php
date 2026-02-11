<?php

namespace Juzaweb\Modules\AdsManagement\Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Juzaweb\Modules\AdsManagement\Ads;
use Juzaweb\Modules\AdsManagement\Models\BannerAds;
use Juzaweb\Modules\AdsManagement\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;

class BannerAdControllerTest extends TestCase
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
        $response = $this->get(route('admin.banner-ads.index'));

        $response->assertStatus(200);
    }

    public function test_create()
    {
        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('bannerPositions')->andReturn(collect([
                'home_banner' => (object) ['name' => 'Home Banner'],
            ]));
        });

        $response = $this->get(route('admin.banner-ads.create'));

        $response->assertStatus(200);
    }

    public function test_store()
    {
        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('bannerPositions')->andReturn(collect([
                'home_banner' => (object) ['name' => 'Home Banner'],
            ]));
        });

        $response = $this->post(route('admin.banner-ads.store'), [
            'name' => 'Test Banner',
            'type' => 'html',
            'position' => 'home_banner',
            'active' => 1,
            'body_html' => '<div>Test</div>',
        ]);

        $response->assertRedirect(route('admin.banner-ads.index'));

        $this->assertDatabaseHas('banner_ads', ['name' => 'Test Banner']);
        $this->assertDatabaseHas('ad_positions', ['position' => 'home_banner']);
    }

    public function test_edit()
    {
        $banner = BannerAds::factory()->create();
        $banner->positions()->create(['position' => 'home_banner']);

        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('bannerPositions')->andReturn(collect([
                'home_banner' => (object) ['name' => 'Home Banner'],
            ]));
        });

        $response = $this->get(route('admin.banner-ads.edit', [$banner->id]));

        $response->assertStatus(200);
    }

    public function test_update()
    {
        $banner = BannerAds::factory()->create();
        $banner->positions()->create(['position' => 'home_banner']);

        $this->mock(Ads::class, function ($mock) {
            $mock->shouldReceive('bannerPositions')->andReturn(collect([
                'sidebar_banner' => (object) ['name' => 'Sidebar Banner'],
            ]));
        });

        $response = $this->put(route('admin.banner-ads.update', [$banner->id]), [
            'name' => 'Updated Banner',
            'type' => 'html',
            'position' => 'sidebar_banner',
            'active' => 1,
            'body_html' => '<div>Updated</div>',
        ]);

        $response->assertRedirect(route('admin.banner-ads.index'));

        $this->assertDatabaseHas('banner_ads', ['id' => $banner->id, 'name' => 'Updated Banner']);
        $this->assertDatabaseHas('ad_positions', ['positionable_id' => $banner->id, 'position' => 'sidebar_banner']);
    }

    public function test_bulk_delete()
    {
        $banners = BannerAds::factory(3)->create();
        $ids = $banners->pluck('id')->toArray();

        $response = $this->postJson(route('admin.banner-ads.bulk'), [
            'action' => 'delete',
            'ids' => $ids,
        ]);

        $response->assertStatus(200);

        foreach ($ids as $id) {
            $this->assertDatabaseMissing('banner_ads', ['id' => $id]);
        }
    }
}
