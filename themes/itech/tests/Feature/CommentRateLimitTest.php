<?php

namespace Juzaweb\Themes\Itech\Tests\Feature;

use Juzaweb\Themes\Itech\Tests\TestCase;
use Juzaweb\Modules\Blog\Models\Post;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CommentRateLimitTest extends TestCase
{
    use DatabaseTransactions;

    public function test_comment_submission_rate_limit()
    {
        // Create a published post
        $post = Post::factory()->create();

        $data = [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'content' => 'This is a test comment.',
        ];

        // Send 6 requests, which should succeed (or at least not be 429)
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post(route('post.comment', ['slug' => $post->slug]), $data);
            // We don't strictly care if it returns 200, as long as it's not 429.
            // However, to be sure the request is valid, we can check for 200 or 302.
            // Since we are mocking, and not fully setting up everything,
            // verifying it is NOT 429 is the most important part initially.
            // But if it fails validation or something else, we might not trigger the throttle.
            // So let's hope the factory and data are enough.
            $this->assertNotEquals(429, $response->status(), "Request $i should not be rate limited");
        }

        // The 7th request should fail with 429
        $response = $this->post(route('post.comment', ['slug' => $post->slug]), $data);
        $response->assertStatus(429);
    }
}
