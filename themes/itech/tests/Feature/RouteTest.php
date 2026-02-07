<?php

namespace Juzaweb\Themes\Itech\Tests\Feature;

use Juzaweb\Themes\Itech\Tests\TestCase;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Blog\Models\Category;
use Juzaweb\Modules\Core\Models\Pages\Page;
use Juzaweb\Modules\Core\Models\User;
use Juzaweb\Modules\Core\Enums\PageStatus;
use Illuminate\Support\Str;

class RouteTest extends TestCase
{
    public function test_home_page()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
    }

    public function test_search_page()
    {
        $response = $this->get(route('search', ['q' => 'test']));

        $response->assertStatus(200);
    }

    public function test_load_more()
    {
        $response = $this->get(route('home.load-more'));

        $response->assertStatus(200);
    }

    public function test_load_posts()
    {
        $response = $this->get(route('home.load-posts'));

        $response->assertStatus(200);
    }

    public function test_post_show()
    {
        $post = Post::factory()->create();

        $response = $this->get(route('post.show', [$post->slug]));

        $response->assertStatus(200);
    }

    public function test_post_comment()
    {
        $post = Post::factory()->create();

        $response = $this->postJson(route('post.comment', [$post->slug]), [
            'name' => 'John Doe',
            'email' => 'john@example.com',
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(200);
    }

    public function test_category_page()
    {
        $category = Category::create([
            'name' => 'Test Category',
            'slug' => 'test-category',
            'description' => 'Test Description',
        ]);

        $response = $this->get(route('blog.category', [$category->slug]));

        $response->assertStatus(200);
    }

    public function test_profile_page_redirects_guests()
    {
        $response = $this->get(route('profile'));

        $response->assertRedirect();
    }

    public function test_profile_page_loads_for_authenticated_user()
    {
        $user = User::factory()->create();
        $user->markEmailAsVerified();

        $response = $this->actingAs($user, 'member')
            ->get(route('profile'));

        $response->assertStatus(200);
    }

    public function test_page_show()
    {
        $page = Page::create([
            'title' => 'Test Page',
            'content' => 'Content of test page',
            'slug' => 'test-page-' . Str::random(5),
            'status' => PageStatus::PUBLISHED,
        ]);

        $response = $this->get(route('page.show', [$page->slug]));

        $response->assertStatus(200);
    }
}
