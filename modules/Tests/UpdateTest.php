<?php

namespace Juzaweb\Tests;

use Illuminate\Support\Facades\File;

class UpdateTest extends TestCase
{
    public function testUpdateCms()
    {
        $this->authUserAdmin();

        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                $this->getCMSVersion(),
                'v2.0',
                File::get($filePath)
            )
        );

        $this->assertEquals($this->getCMSVersion(), 'v2.0');

        for ($i=1;$i<=6;$i++) {
            $this->printText("Test update step {$i}");

            $response = $this->json('POST', "admin-cp/update/cms/{$i}");

            $this->printText($response->getContent());

            $response->assertJson(['status' => true]);
        }

        $this->assertNotEquals($this->getCMSVersion(), 'v2.0');
    }

    public function testUpdateCommand()
    {
        $filePath = base_path('modules/CMS/Version.php');

        File::put(
            $filePath,
            str_replace(
                $this->getCMSVersion(),
                'v2.0',
                File::get($filePath)
            )
        );

        $this->assertEquals($this->getCMSVersion(), 'v2.0');

        $this->artisan('juzacms:update')
            ->assertExitCode(0);

        $this->assertNotEquals($this->getCMSVersion(), 'v2.0');
    }

    protected function getCMSVersion()
    {
        $file = File::get(base_path('modules/CMS/Version.php'));
        return explode("'", $file)[1];
    }
}
