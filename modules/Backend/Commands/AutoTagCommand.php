<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;

class AutoTagCommand extends Command
{
    protected $signature = 'juza:auto-tags';

    protected array $tagsByType;

    protected int $postLimit = 500;

    public function handle(): int
    {
        $tags = Taxonomy::where('taxonomy', '=', 'tags')
            ->limit(50)
            ->orderBy('id', 'DESC')
            ->get();

        if ($tags->isEmpty()) {
            return self::SUCCESS;
        }

        $lastId = get_config('seo_last_update_tag', 0);

        $posts = Post::where('status', '=', Post::STATUS_PUBLISH)
            ->where('id', '>', $lastId)
            ->where(
                function (Builder $q) use ($tags) {
                    $q->whereRaw('1=0');
                    foreach ($tags as $tag) {
                        $q->orWhere('title', 'like', "%{$tag->name}%");
                        $q->orWhere('description', 'like', "%{$tag->name}%");
                    }
                }
            )
            ->orderBy('id', 'ASC')
            ->limit($this->postLimit)
            ->get();

        foreach ($posts as $post) {
            $tagIds = [];

            $postTags = $this->getTagByType($post->type, $tags);
            foreach ($postTags as $tag) {
                if ($this->hasTag($tag, $post)) {
                    $tagIds[$tag->id] = ['term_type' => $post->type];
                }
            }

            $post->tags()->syncWithoutDetaching($tagIds);

            $this->info("Add tags {$post->id}");
        }

        if ($posts->isNotEmpty()) {
            set_config('seo_last_update_tag', $posts->last()->id);
        }

        return self::SUCCESS;
    }

    private function getTagByType(string $type, Collection $tags)
    {
        if (isset($this->tagsByType[$type])) {
            return $this->tagsByType[$type];
        }

        $this->tagsByType[$type] = $tags->where('post_type', '=', $type);

        return $this->tagsByType[$type];
    }

    private function hasTag(Taxonomy $tag, Post $post): bool
    {
        return mb_stripos(mb_strtolower($post->title), mb_strtolower($tag->name)) !== false
            || mb_stripos(mb_strtolower($post->description), mb_strtolower($tag->name)) !== false;
    }
}
