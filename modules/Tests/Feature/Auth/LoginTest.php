<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Auth;

use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class LoginTest extends TestCase
{
    public function testIndex()
    {
        $this->get('admin-cp/login')->assertStatus(200);
    }

    public function testLogin()
    {
        $user = User::factory()->create();

        $this->json(
            'POST',
            '/admin-cp/login',
            [
                'email' => $user->email,
                'password' => '12345678',
            ]
        )
            ->assertJson(['status' => true]);
    }
}
