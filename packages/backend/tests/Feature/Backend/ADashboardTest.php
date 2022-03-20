<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzawebcms/juzawebcms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://github.com/juzawebcms/juzawebcms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Feature\Backend;

use Illuminate\Support\Facades\Auth;
use Juzaweb\Models\User;
use Juzaweb\Backend\Tests\TestCase;

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
}
