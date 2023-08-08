<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;

class AutoTagJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout = 3600;

    public function __construct(
        protected string $lastDate,
        protected int $limit
    ) {
    }

    public function handle(): void
    {
        $posts = Post::where('status', '=', Post::STATUS_PUBLISH)
            ->where('updated_at', '>', $this->lastDate)
            ->whereDoesntHave('taxonomies', fn($q) => $q->where('taxonomy', 'tags'))
            ->orderBy('updated_at', 'ASC')
            ->limit($this->limit)
            ->get();

        Taxonomy::select(['id'])
            ->where('taxonomy', '=', 'tags')
            ->orderBy('id', 'DESC')
            ->chunkById(
                1000,
                function ($tags) use ($posts) {
                    foreach ($posts as $post) {
                        $tagIds = [];
                        foreach ($tags as $tag) {
                            if ($this->hasTag($tag, $post)) {
                                $tagIds[$tag->id] = ['term_type' => $post->type];
                            }
                        }

                        if ($tagIds) {
                            $post->tags()->syncWithoutDetaching($tagIds);
                        }
                    }
                }
            );
    }

    private function hasTag(Taxonomy $tag, Post $post): bool
    {
        return mb_stripos(mb_strtolower($post->title), mb_strtolower(" {$tag->name} ")) !== false
            || mb_stripos(mb_strtolower($post->content), mb_strtolower(" {$tag->name} ")) !== false;
    }
}
