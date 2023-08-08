<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Backend;

use Faker\Generator as Faker;
use Juzaweb\Tests\TestCase;
use Juzaweb\CMS\Models\User;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->authUserAdmin();
    }

    public function testIndexAccess()
    {
        $this->get("/admin-cp/users")
            ->assertStatus(200);
    }

    public function testCreateAccess()
    {
        $this->get("/admin-cp/users/create")
            ->assertStatus(200);
    }

    public function testCreate()
    {
        $faker = app(Faker::class);
        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'status' => 'active',
        ];

        $response = $this->post("/admin-cp/users", $data)
            ->assertStatus(302);

        $response->assertSessionHasErrors(['password']);

        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'status' => 'active',
            'password' => '123456@123',
            'password_confirmation' => '123456123',
        ];

        $response = $this->post("/admin-cp/users", $data)
            ->assertStatus(302);

        $response->assertSessionHasErrors(['password']);

        $data = [
            'name' => $faker->name,
            'email' => $faker->email,
            'status' => 'active',
            'password' => '123456@123',
            'password_confirmation' => '123456@123',
        ];

        $this->post("/admin-cp/users", $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            'users',
            [
                'name' => $data['name'],
                'email' => $data['email'],
            ]
        );
    }

    public function testEdit()
    {
        $faker = app(Faker::class);
        $user = User::where('is_admin', '!=', 1)->first();

        $data = [
            'name' => $faker->name,
            'status' => 'banned',
            'id' => $user->id,
        ];

        $this->put("/admin-cp/users/{$user->id}", $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $user = $user->fresh();

        $this->assertTrue($user->name == $data['name']);
    }

    public function testChangePassword()
    {
        $user = User::where('is_admin', '!=', 1)->first();
        $data = [
            'name' => $user->name,
            'status' => $user->status,
            'password' => 'juzacms@123',
            'password_confirmation' => 'juzacms@123',
        ];

        $this->put("/admin-cp/users/{$user->id}", $data)
            ->assertStatus(302)
            ->assertSessionHasNoErrors();

        $this->assertTrue(
            auth()->attempt(
                [
                    'email' => $user->email,
                    'password' => 'juzacms@123',
                ]
            )
        );
    }
}
