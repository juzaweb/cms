<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Tests\Feature\Backend;

use Illuminate\Support\Facades\Auth;
use Juzaweb\Models\User;
use Juzaweb\Tests\TestCase;

class ADashboardTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('is_admin', '=', 1)
            ->first();

        Auth::loginUsingId($this->user->id);
    }

    public function testIndex()
    {
        $response = $this->get('/admin-cp');

        $response->assertStatus(200);
    }
    
    public function testChartData()
    {
        $url = '/admin-cp/dashboard/views-chart';
    
        $response = $this->get($url);
    
        $response->assertStatus(200);
    }
    
    public function testDataUser()
    {
        $url = '/admin-cp/dashboard/users?sort=id&order=desc&offset=0&limit=5';
    
        $response = $this->get($url);
    
        $response->assertStatus(200);
        
        $response->assertJsonStructure(
            [
                'total',
                'rows'
            ]
        );
    }
}
