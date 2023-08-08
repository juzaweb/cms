<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Unit;

use Juzaweb\Tests\TestCase;

class OptimizeTest extends TestCase
{
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
