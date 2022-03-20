<?php
/**
 * Created by PhpStorm.
 * User: dtv
 * Date: 10/15/2021
 * Time: 1:00 PM
 */

namespace Juzaweb\Backend\Tests\Install;

use Juzaweb\Support\Manager\UpdateManager;
use Juzaweb\Backend\Tests\TestCase;

class UpdateTest extends TestCase
{
    public function testUpdateCms()
    {
        $response = $this->post('admin-cp/updates', [
            '_token' => csrf_token(),
        ]);

        $this->assertEquals(302, $response->getStatusCode());
    }

    public function testUpdateCommand()
    {
        $this->artisan('juzacms:update')
            ->assertExitCode(0);

        $updater = new UpdateManager('core');
        $this->assertTrue(version_compare($updater->getCurrentVersion(), $updater->getVersionAvailable(), '>='));
    }
}