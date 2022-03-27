<?php

namespace Juzaweb\Backend\Tests\Install;

use Illuminate\Support\Facades\File;
use Juzaweb\Backend\Tests\TestCase;
use Juzaweb\Version;

class UpdateTest extends TestCase
{
    /*public function testUpdateCms()
    {
        $response = $this->post('admin-cp/updates', [
            '_token' => csrf_token(),
        ]);

        $this->assertEquals(302, $response->getStatusCode());
    }*/

    public function testUpdateCommand()
    {
        $ver = Version::getVersion();
        $filePath = base_path('packages/cms/src/Version.php');
        File::put(
            str_replace(
                $ver,
                'v2.0',
                File::get($filePath)
            ),
            $filePath
        );
        
        $this->artisan('juzacms:update')
            ->assertExitCode(0);
    
        $ver = Version::getVersion();
        $this->assertTrue($ver != 'v2.0');
    }
}