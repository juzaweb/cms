<?php

namespace Juzaweb\Tests;

use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Version;

class UpdateTest extends TestCase
{
    public function testUpdateCms()
    {
        $version = Version::getVersion();

        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                $version,
                'v2.0',
                File::get($filePath)
            )
        );

        for ($i=1;$i<=6;$i++) {
            $this->printText("Test update step {$i}");

            $response = $this->json('POST', "admin-cp/update/cms/{$i}");

            $this->printText($response->getContent());

            $response->assertJson(['status' => true]);
        }

        $version = Version::getVersion();

        $this->assertNotEquals($version, 'v2.0');
    }

    public function testUpdateCommand()
    {
        $version = Version::getVersion();

        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                $version,
                'v2.0',
                File::get($filePath)
            )
        );

        $this->artisan('juzacms:update')
            ->assertExitCode(0);

        $version = Version::getVersion();

        $this->assertNotEquals($version, 'v2.0');
    }
}
