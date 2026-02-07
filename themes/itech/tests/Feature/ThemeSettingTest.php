<?php

namespace Juzaweb\Themes\Itech\Tests\Feature;

use Juzaweb\Themes\Itech\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThemeSettingTest extends TestCase
{
    use DatabaseTransactions;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_super_admin' => 1,
            'email_verified_at' => now(),
        ]);

        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('admin.theme.settings'));

        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $response = $this->postJson(route('admin.theme.settings.update'), [
            'facebook' => 'https://facebook.com/test',
            'x' => 'https://x.com/test',
        ]);

        $response->assertStatus(200);

        $response->assertJson([
            'success' => true,
        ]);
    }
}
