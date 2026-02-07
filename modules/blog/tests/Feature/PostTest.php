<?php

namespace Juzaweb\Modules\Blog\Tests\Feature;

use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Blog\Tests\TestCase;
use Juzaweb\Modules\Core\Models\User;

class PostTest extends TestCase
{
    protected $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'is_super_admin' => 1,
        ]);
    }

    public function test_index_page()
    {
        $response = $this->actingAs($this->user)
            ->get('admin/posts');

        $response->assertStatus(200);
    }

    public function test_create_post()
    {
        $data = [
            'title' => 'Test Post',
            'content' => 'Test Content',
            'status' => 'published',
        ];

        $response = $this->actingAs($this->user)
            ->postJson('admin/posts', $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'status' => 'published',
        ]);

        // Check translation
        $this->assertDatabaseHas('post_translations', [
            'title' => 'Test Post',
            'content' => 'Test Content',
        ]);
    }

    public function test_update_post()
    {
        $post = Post::factory()->create();

        $data = [
            'title' => 'Updated Post',
            'content' => 'Updated Content',
            'status' => 'private',
        ];

        $response = $this->actingAs($this->user)
            ->putJson("admin/posts/{$post->id}", $data);

        $response->assertStatus(200);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'status' => 'private',
        ]);

        $this->assertDatabaseHas('post_translations', [
            'post_id' => $post->id,
            'title' => 'Updated Post',
        ]);
    }

    public function test_delete_post()
    {
        $post = Post::factory()->create();

        $response = $this->actingAs($this->user)
            ->postJson('admin/posts/bulk', [
                'action' => 'delete',
                'ids' => [$post->id],
            ]);

        $response->assertStatus(200);

        $this->assertDatabaseMissing('posts', [
            'id' => $post->id,
        ]);
    }
}
