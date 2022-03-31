<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Tests\Feature\Frontend;

use Faker\Generator as Faker;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Tests\TestCase;

class APostTest extends TestCase
{
    protected $postTypes;
    
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
            $posts = Post::where('type', $key)->limit(2)->get();
            
            foreach ($posts as $post) {
                $response = $this->get($this->getUrlPost($postType, $post));
    
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
        
            $posts = Post::where('type', $key)->limit(2)->get();
        
            foreach ($posts as $post) {
                $this->post(
                    $this->getUrlPost($postType, $post),
                    [
                        'name' => $faker->name,
                        'email' => 'required|email|max:100',
                        'content' => 'required|max:300',
                    ]
                )->assertStatus(302)
                ->assertSessionHasErrors(['email']);
    
                $data = [
                    'name' => $faker->name,
                    'email' => $faker->email,
                    'content' => 'required|max:300',
                ];
                $this->post(
                    $this->getUrlPost($postType, $post),
                    $data
                )->assertStatus(302);
    
                $this->assertDatabaseHas('comments', $data);
            }
        }
    }
    
    protected function getUrlPost($postType, $post)
    {
        $key = $postType->get('key');
        if ($key == 'pages') {
            $base = '';
        } else {
            $permalink = HookAction::getPermalinks($key);
            $base = $permalink->get('base');
        }
    
        return $base ? "/{$base}/{$post->slug}" : "/{$post->slug}";
    }
}