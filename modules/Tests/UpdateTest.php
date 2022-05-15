<?php

namespace Juzaweb\Tests;

use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Version;

class UpdateTest extends TestCase
{
    public function testUpdateCms()
    {
        $this->authUserAdmin();

        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                Version::getVersion(),
                'v2.0',
                File::get($filePath)
            )
        );

        $this->assertEquals(Version::getVersion(), 'v2.0');

        for ($i=1;$i<=6;$i++) {
            $this->printText("Test update step {$i}");

            $response = $this->json('POST', "admin-cp/update/cms/{$i}");

            $this->printText($response->getContent());

            $response->assertJson(['status' => true]);
        }

        $this->assertNotEquals(Version::getVersion(), 'v2.0');
    }

    public function testUpdateCommand()
    {
        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                Version::getVersion(),
                'v2.0',
                File::get($filePath)
            )
        );

        $this->assertEquals(Version::getVersion(), 'v2.0');

        $this->artisan('juzacms:update')
            ->assertExitCode(0);

        $this->assertNotEquals(Version::getVersion(), 'v2.0');
    }
}
