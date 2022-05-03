<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Tests\Feature\Auth;

use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin()
    {
        $this->get('admin-cp/login')->assertStatus(200);

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
