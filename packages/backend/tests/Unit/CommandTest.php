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
        $this->artisan('migrate:refresh')
            ->assertExitCode(0);
    }

    public function testSeed()
    {
        $this->artisan('db:seed')
            ->assertExitCode(0);
    }

    public function testMakeAdmin()
    {
        $this->artisan('juzacms:make-admin')
            ->expectsQuestion('Full Name?', 'Taylor Otwell')
            ->expectsQuestion('Email?', 'demo@gmail.com')
            ->expectsQuestion('Password?', '12345678')
            ->assertExitCode(0);
    }
    
    public function testOptimize()
    {
        $this->artisan('optimize')
            ->assertExitCode(0);
    }
    
    public function testOptimizeClear()
    {
        $this->artisan('optimize:clear')
            ->assertExitCode(0);
    }
}
