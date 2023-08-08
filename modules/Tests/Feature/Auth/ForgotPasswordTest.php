<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Auth;

use Juzaweb\Backend\Models\EmailTemplate;
use Juzaweb\Backend\Models\PasswordReset;
use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    private User $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = User::active()->first();
    }

    public function testIndex()
    {
        $this->get('admin-cp/forgot-password')->assertStatus(200);
    }

    public function testSubmit()
    {
        $this->json(
            'POST',
            'admin-cp/forgot-password',
            ['email' => $this->user->email]
        )->assertJson(['status' => true]);

        $template = EmailTemplate::whereCode('forgot_password')->first();

        $this->assertDatabaseHas('password_resets', ['email' => $this->user->email]);

        $this->assertDatabaseHas(
            'email_lists',
            ['email' => $this->user->email, 'template_id' => $template->id]
        );
    }

    public function testResetPassword()
    {
        $passwordReset = PasswordReset::whereEmail($this->user->email)->first();

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
            ->assertStatus(200)
            ->assertJson(['status' => true]);

        $this->assertDatabaseMissing(
            'password_resets',
            ['email' => $this->user->email]
        );
    }
}
