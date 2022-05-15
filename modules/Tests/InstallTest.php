<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests;

use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Support\Installer;

class InstallTest extends TestCase
{
    public function testInstallCommand()
    {
        $this->resetTestData();

        $this->artisan('juzacms:install')
            ->expectsQuestion('Full Name?', 'Taylor Otwell')
            ->expectsQuestion('Email?', 'demo@gmail.com')
            ->expectsQuestion('Password?', '12345678')
            ->assertExitCode(0);

        $this->assertTrue(file_exists(Installer::installedPath()));

        $this->assertDatabaseHas('users', ['email' => 'demo@gmail.com', 'is_admin' => 1]);
    }

    protected function resetTestData()
    {
        $this->artisan('migrate:reset')
            ->assertExitCode(0);

        if (file_exists(Installer::installedPath())) {
            unlink(Installer::installedPath());
        }
    }
}
