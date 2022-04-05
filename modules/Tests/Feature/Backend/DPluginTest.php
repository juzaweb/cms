<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Feature\Backend;

use Juzaweb\Backend\Tests\TestCase;

class DPluginTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        
        $this->authUserAdmin();
    }
    
    public function testIndexPlugin()
    {
        $this->get("/admin-cp/plugins")
            ->assertStatus(200);
    }
}
