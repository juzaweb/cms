<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Backend;

use Juzaweb\Tests\TestCase;

class PluginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->authUserAdmin();
    }

    public function testIndexPlugin()
    {
        $this->get("/admin-cp/plugins")
            ->assertStatus(200);
    }

    public function testActivePlugin()
    {
        $this->json(
            'POST',
            'admin-cp/plugins/bulk-actions',
            [
                'ids' => ['juzaweb/example'],
                'action' => 'activate'
            ]
        )
            ->assertJson(['status' => true]);
    }

    public function testDeactivePlugin()
    {
        $this->json(
            'POST',
            'admin-cp/plugins/bulk-actions',
            [
                'ids' => ['juzaweb/example'],
                'action' => 'deactivate'
            ]
        )
            ->assertJson(['status' => true]);
    }

    public function testDeletePlugin()
    {
        config()->set('juzaweb.plugin.enable_upload', true);

        $this->json(
            'POST',
            'admin-cp/plugins/bulk-actions',
            [
                'ids' => ['juzaweb/example'],
                'action' => 'delete'
            ]
        )
            ->assertJson(['status' => true]);

        $this->assertFileDoesNotExist(
            config('juzaweb.plugin.path') . '/juzaweb/example/composer.json'
        );
    }
}
