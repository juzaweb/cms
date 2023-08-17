<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Commands\Post;

use Illuminate\Console\Command;
use Juzaweb\Backend\Models\Post;

class GeneratePostUUIDCommand extends Command
{
    protected $name = 'posts:generate-uuid-missing';

    protected $description = 'Generate post uuid missing command.';

    public function handle(): void
    {
        Post::whereNull('uuid')->get()->each(
            fn($post) => $this->generateUUID($post)
        );
    }

    protected function generateUUID(Post $post): void
    {
        $post->setAttribute('uuid', Post::generateUniqueUUID());
        $post->save();

        $this->info("Generated for post {$post->id}");
    }
}
