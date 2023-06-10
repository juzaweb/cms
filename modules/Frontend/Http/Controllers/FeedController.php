<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Juzaweb\CMS\Http\Controllers\Controller;
use Spatie\Feed\Feed;

class FeedController extends Controller
{
    public function index(): Feed
    {
        if (!get_config('jw_enable_post_feed', true)) {
            abort(404);
        }

        $posts = Post::with(['createdBy'])
            ->select(
                [
                    'id',
                    'title',
                    'content',
                    'updated_at',
                    'slug',
                    'type',
                    'created_by'
                ]
            )
            ->wherePublish()
            ->orderBy('id', 'DESC')
            ->limit(get_config('posts_per_rss', 10))
            ->get();

        return new Feed(
            (string) get_config('title'),
            $posts,
            request()->url(),
            $feed['view'] ?? 'feed::atom',
            (string) get_config('description', ''),
            $feed['language'] ?? 'en-US',
            $feed['image'] ?? '',
            $feed['format'] ?? 'atom'
        );
    }

    public function taxonomy($slug): Feed
    {
        if (!get_config('jw_enable_taxonomy_feed', true)) {
            abort(404);
        }

        $taxonomy = Taxonomy::findBySlugOrFail($slug);

        $posts = Post::with(['createdBy'])
            ->select(
                [
                    'id',
                    'title',
                    'content',
                    'updated_at',
                    'slug',
                    'type',
                    'created_by'
                ]
            )
            ->wherePublish()
            ->whereTaxonomy($taxonomy->id)
            ->latest()
            ->limit(get_config('posts_per_rss', 10))
            ->get();

        return new Feed(
            (string) get_config('title'),
            $posts,
            request()->url(),
            'feed::atom',
            (string) get_config('description', ''),
            'en-US',
            '',
            'atom'
        );
    }
}
