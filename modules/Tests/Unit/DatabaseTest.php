<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Unit;

use Juzaweb\CMS\Database\Seeders\DatabaseSeeder;
use Juzaweb\Tests\TestCase;

class DatabaseTest extends TestCase
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
                '--class' => DatabaseSeeder::class
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
