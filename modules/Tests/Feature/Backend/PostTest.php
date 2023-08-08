<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://github.com/juzaweb/cms
 * @license    GNU V2
 */

namespace Juzaweb\Tests\Feature\Backend;

use Faker\Generator as Faker;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Models\User;
use Juzaweb\Tests\TestCase;

class PostTest extends TestCase
{
    protected User|null $user;

    protected Collection $postTypes;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::where('is_admin', '=', 1)->first();

        Auth::loginUsingId($this->user->id);

        $this->postTypes = HookAction::getPostTypes();
    }

    public function testPostTypes()
    {
        foreach ($this->postTypes as $key => $postType) {
            $this->indexTest($key);

            $this->createTest($key, $postType);

            $this->updateTest($key, $postType);
        }
    }

    protected function indexTest($key): void
    {
        $response = $this->get("/admin-cp/post-type/{$key}");

        $response->assertStatus(200);
    }

    protected function createTest($key, $postType): void
    {
        $index = "/admin-cp/post-type/{$key}/create";
        $response = $this->get($index);

        $this->printText("Test {$index}");

        $response->assertStatus(200);

        if ($post = $this->makerData($postType)) {
            $create = "/admin-cp/post-type/{$key}";
            $this->printText("Test post create {$create}");

            $data = $post;
            unset($data['slug']);

            $this->json('POST', $create, $post)
                ->assertStatus(200)
                ->assertJson(['status' => true]);

            /*$slug = substr($post['title'], 0, 70);
            $slug = Str::slug($slug);

            $this->assertDatabaseHas(
                'posts',
                [
                    'slug' => $slug,
                    'type' => $key,
                ]
            );*/
        }
    }

    protected function updateTest($key, $postType): void
    {
        if ($post = $this->makerData($postType)) {
            $model = app($postType->get('model'))->first(['id']);
            $url = "/admin-cp/post-type/{$key}/{$model->id}/edit";

            $response = $this->get($url);

            $response->assertStatus(200);

            $this->put("/admin-cp/post-type/{$key}/{$model->id}", $post);

            $model = app($postType->get('model'))
                ->where('id', '=', $model->id)
                ->first();

            $this->assertEquals($post['title'], $model->title);
        }
    }

    /**
     *
     * @param Collection $postType
     *
     * @return array|bool
     */
    protected function makerData(Collection $postType): bool|array
    {
        $faker = app(Faker::class);
        $title = $faker->sentence(10);

        $post = [
            'title' => $title,
            'content' => $faker->sentence(50),
            'status' => 'publish',
            'type' => $postType->get('key'),
            'slug' => Str::slug($title),
        ];

        $taxonomies = HookAction::getTaxonomies($postType->get('key'));
        foreach ($taxonomies as $taxonomy) {
            $ids = app($taxonomy->get('model'))
                ->where('taxonomy', '=', $taxonomy->get('taxonomy'))
                ->where('post_type', '=', $postType->get('key'))
                ->inRandomOrder()
                ->limit(5)
                ->pluck('id')
                ->toArray();

            $post[$taxonomy->get('taxonomy')] = $ids;
        }

        return $post;
    }
}
