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

use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    public function testIndex()
    {
        $this->get('admin-cp/forgot-password')->assertStatus(200);
    }

    public function testSubmit()
    {
        $user = User::active()->first();

        $this->json(
            'POST',
            'admin-cp/forgot-password',
            ['email' => $user->email]
        )->assertJson(['status' => true]);

        $this->assertDatabaseHas('password_resets', ['email' => $user->email]);

        $this->assertDatabaseHas('email_lists', ['email' => $user->email]);
    }

    public function testResetPassword()
    {
        $user = User::active()->first();

        $passwordReset = PasswordReset::whereEmail($user->email)->first();

        $uri = "admin-cp/reset-password/{$passwordReset->email}/{$passwordReset->token}";

        $this->get($uri)->assertStatus(200);

        $this->json(
            'POST',
            $uri,
            [
                'password' => 'Asd123@@',
                'password_confirmation' => 'Asd123@',
            ]
        )
            ->assertJsonValidationErrors(['password']);

        $this->json(
            'POST',
            $uri,
            [
                'password' => 'Asd123@@',
                'password_confirmation' => 'Asd123@@',
            ]
        )
            ->assertStatus(302)
            ->assertRedirect(route('login'));

        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
    }
}
