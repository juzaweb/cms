<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Unit;

use Juzaweb\Tests\TestCase;

class BDatabaseTest extends TestCase
{
    public function testMigration()
    {
        $this->artisan('migrate:refresh')
            ->assertExitCode(0);
    }

    public function testSeed()
    {
        $this->artisan(
            'db:seed',
            [
                '--class' => 'Juzaweb\CMS\Database\Seeders\DatabaseSeeder'
            ]
        )
            ->assertExitCode(0);
    }

    public function testMakeAdmin()
    {
        $this->artisan('juzacms:make-admin')
            ->expectsQuestion('Full Name?', 'Taylor Otwell')
            ->expectsQuestion('Email?', 'admin@admin.com')
            ->expectsQuestion('Password?', 'admin@admin.com')
            ->assertExitCode(0);
    }

    public function testMakeEmailTemplate()
    {
        $this->artisan('mail:generate-template')
            ->assertExitCode(0);
    }
}
