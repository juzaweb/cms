<?php

namespace Juzaweb\Backend\Http\Controllers\Frontend;

use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\Taxonomy;
use Spatie\Feed\Feed;

class FeedController
{
    public function index()
    {
        $posts = Post::with(['createdBy'])
        ->select([
            'id',
            'title',
            'description',
            'updated_at',
            'slug',
            'type',
            'created_by'
        ])
            ->wherePublish()
            ->latest()
            ->limit(10)
            ->get();

        return new Feed(
            (string) get_config('title'),
            $posts,
            request()->url(),
            $feed['view'] ?? 'feed::atom',
            (string) get_config('description', ''),
            $feed['language'] ?? 'en-US'
        );
    }

    public function taxonomy($slug)
    {
        $taxonomy = Taxonomy::findBySlugOrFail($slug);

        $posts = Post::with(['createdBy'])
            ->select([
                'id',
                'title',
                'description',
                'updated_at',
                'slug',
                'type',
                'created_by'
            ])
            ->wherePublish()
            ->whereTaxonomy($taxonomy->id)
            ->latest()
            ->limit(10)
            ->get();

        return new Feed(
            (string) get_config('title'),
            $posts,
            request()->url(),
            $feed['view'] ?? 'feed::atom',
            (string) get_config('description', ''),
            $feed['language'] ?? 'en-US'
        );
    }
}
