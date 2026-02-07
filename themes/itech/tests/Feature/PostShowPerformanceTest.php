<?php

namespace Juzaweb\Themes\Itech\Tests\Feature;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Blog\Providers\BlogServiceProvider;
use Juzaweb\Themes\Itech\Tests\TestCase;
use Juzaweb\Modules\Core\Providers\CoreServiceProvider;
use Juzaweb\Themes\Itech\Providers\ThemeServiceProvider;

class PostShowPerformanceTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Juzaweb\Hooks\HooksServiceProvider::class,
            \Juzaweb\QueryCache\QueryCacheServiceProvider::class,
            CoreServiceProvider::class,
            ThemeServiceProvider::class,
            BlogServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        $app['config']->set('translatable.locales', ['en']);
        $app['config']->set('translatable.locale', 'en');
        $app['config']->set('translatable.fallback_locale', 'en');
    }

    protected function defineDatabaseMigrations()
    {
        parent::defineDatabaseMigrations();
        $this->loadMigrationsFrom(__DIR__ . '/../../vendor/juzaweb/blog/database/migrations');
    }

    protected function createMixManifest(): void
    {
        parent::createMixManifest();

        $path = public_path('themes/itech');
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        if (!file_exists($path . '/mix-manifest.json')) {
            file_put_contents($path . '/mix-manifest.json', '{}');
        }
    }

    public function test_post_show_performance()
    {
        // Create a post with tags
        $post = Post::factory()->create([
            'status' => 'published',
        ]);

        // Add some tags
        $post->syncTags(['tag1', 'tag2', 'tag3']);

        // Enable query logging
        DB::enableQueryLog();

        // Request the post detail page
        $response = $this->get(route('post.show', $post->slug));
        $response->assertStatus(200);

        DB::flushQueryLog();

        // Request again to check cache
        $response = $this->get(route('post.show', $post->slug));
        $response->assertStatus(200);

        // Get the queries
        $queries = DB::getQueryLog();
        $queryCount = count($queries);

        $this->assertLessThan(5, $queryCount);
    }
}
