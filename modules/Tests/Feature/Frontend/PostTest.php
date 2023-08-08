<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Frontend;

use Faker\Generator as Faker;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\Tests\TestCase;

class PostTest extends TestCase
{
    protected Collection $postTypes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->postTypes = HookAction::getPostTypes();
    }

    public function testIndex()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testDetail()
    {
        foreach ($this->postTypes as $key => $postType) {
            $posts = Post::wherePublish()
                ->where('type', $key)
                ->limit(2)
                ->get();

            foreach ($posts as $post) {
                $url = $this->getUrlPost($postType, $post);

                $response = $this->get($url);

                $this->printText("Test {$url}");

                $response->assertStatus(200);
            }
        }
    }

    public function testComment()
    {
        $faker = app(Faker::class);

        foreach ($this->postTypes as $key => $postType) {
            if (!in_array('comment', $postType->get('supports'))) {
                continue;
            }

            $posts = Post::wherePublish()
                ->where('type', $key)
                ->limit(2)
                ->get();

            foreach ($posts as $post) {
                $url = $this->getUrlPost($postType, $post);
                $this->printText("Test Comment {$url}");

                $this->post(
                    $url,
                    [
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'content' => '',
                    ]
                )
                    ->assertStatus(302)
                    ->assertSessionHasErrors(['content']);

                $this->post(
                    $url,
                    [
                        'name' => $faker->name,
                        'email' => 'required|email|max:100',
                        'content' => 'required|max:300',
                    ]
                )
                    ->assertStatus(302)
                    ->assertSessionHasErrors(['email']);

                $data = [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'content' => 'required|max:300',
                ];

                $this->post($url, $data)->assertStatus(302);

                $this->assertDatabaseHas('comments', $data);
            }
        }
    }

    public function testAuthComment()
    {
        $this->authUserAdmin();

        foreach ($this->postTypes as $key => $postType) {
            if (!in_array('comment', $postType->get('supports'))) {
                continue;
            }

            $posts = Post::where('type', $key)->limit(2)->get();

            foreach ($posts as $post) {
                $this->post(
                    $this->getUrlPost($postType, $post),
                    [
                        'content' => '',
                    ]
                )
                    ->assertStatus(302)
                    ->assertSessionHasErrors(['content']);

                $this->post(
                    $this->getUrlPost($postType, $post),
                    [
                        'content' => 'required|max:300',
                    ]
                )
                    ->assertStatus(302);

                $this->assertDatabaseHas(
                    'comments',
                    ['content' => 'required|max:300']
                );
            }
        }
    }

    protected function getUrlPost($postType, $post): string
    {
        $key = $postType->get('key');
        $base = '';
        if ($key != 'pages') {
            $permalink = HookAction::getPermalinks($key);
            $base = $permalink->get('base');
        }

        return $base ? "/{$base}/{$post->slug}" : "/{$post->slug}";
    }
}
