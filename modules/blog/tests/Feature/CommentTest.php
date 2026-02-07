<?php

namespace Juzaweb\Modules\Blog\Tests\Feature;

use Juzaweb\Modules\Blog\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;
use Juzaweb\Modules\Core\Models\Comment;
use Illuminate\Support\Facades\Hash;

class CommentTest extends TestCase
{
    protected $admin;

    protected function setUp(): void
    {
        parent::setUp();

        // Create admin user
        $this->admin = new User();
        $this->admin->forceFill([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' => 1,
            'email_verified_at' => now(),
        ]);
        $this->admin->save();
    }

    public function test_index_page_can_be_accessed()
    {
        $response = $this->actingAs($this->admin)
            ->get('admin/comments');

        $response->assertStatus(200);
        $response->assertSee('Comments'); // Check title
    }

    public function test_regular_user_cannot_access_comments_index()
    {
        $user = new User();
        $user->forceFill([
            'name' => 'User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'is_super_admin' => 0,
            'email_verified_at' => now(),
        ]);
        $user->save();

        $response = $this->actingAs($user)
            ->get('admin/comments');

        $response->assertStatus(403);
    }

    public function test_bulk_actions_are_visible()
    {
        $response = $this->actingAs($this->admin)
            ->get('admin/comments');

        $response->assertStatus(200);
        $response->assertSee('Bulk Actions');
        $response->assertSee('Approve');
        $response->assertSee('Reject');
        $response->assertSee('Delete');
    }

    public function test_cannot_access_create_page()
    {
        $response = $this->actingAs($this->admin)
            ->get('admin/comments/create');

        // It returns 405 because it matches admin/comments/{id} which only allows DELETE
        $response->assertStatus(405);
    }

    public function test_cannot_access_edit_page()
    {
        $comment = $this->createComment();

        $response = $this->actingAs($this->admin)
            ->get("admin/comments/{$comment->id}/edit");

        $response->assertStatus(404);
    }

    public function test_delete_comment()
    {
        $comment = $this->createComment();

        $response = $this->actingAs($this->admin)
            ->delete("admin/comments/{$comment->id}");

        // It redirects back
        $response->assertRedirect();

        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }

    protected function createComment()
    {
        return Comment::forceCreate([
            'commentable_type' => 'Juzaweb\Modules\Blog\Models\Post',
            'commentable_id' => 999,
            'commented_type' => User::class,
            'commented_id' => $this->admin->id,
            'content' => 'Test Comment Content ' . uniqid(),
            'status' => 'approved',
        ]);
    }
}
