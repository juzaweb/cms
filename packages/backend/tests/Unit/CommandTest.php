<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Unit;

use Juzaweb\Backend\Tests\TestCase;

class CommandTest extends TestCase
{
    public function testMigration()
    {
        $this->artisan('migrate')
            ->assertExitCode(0);
    }

    public function testSeed()
    {
        $this->artisan('db:seed')
            ->assertExitCode(0);
    }

    public function testOptimize()
    {
        $this->artisan('optimize')
            ->assertExitCode(0);
    }

    public function testImportThemes()
    {
        $this->artisan('jw:import-themes')
            ->assertExitCode(0);
    }

    public function testImportPlugins()
    {
        $this->artisan('jw:import-plugins')
            ->assertExitCode(0);
    }
}
