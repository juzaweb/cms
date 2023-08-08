<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Backend;

use Illuminate\Support\Facades\Auth;
use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class DashboardTest extends TestCase
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
