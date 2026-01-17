<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itech\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;

class HomeController extends ThemeController
{
    public function index()
    {
        $recentPosts = Post::whereFrontend()
            ->with(['categories' => fn ($q) => $q->whereFrontend()])
            ->latest()
            ->paginate(10);

        return view(
            'itech::index',
            [
                ...compact('recentPosts'),
                'title' => setting('title'),
                'description' => setting('description'),
            ]
        );
    }

    public function search(Request $request)
    {
        $tag = $request->input('tag');

        $posts = Post::whereFrontend()
            ->with(['categories' => fn ($q) => $q->whereFrontend()])
            ->when(
                $request->input('q'),
                fn ($query, $q) => $query->search($q)
            )
            ->when(
                $tag,
                fn ($query) => $query->whereHas(
                    'tags',
                    fn ($q) => $q->where('name', $tag)
                )
            )
            ->latest()
            ->paginate(10);

        return view(
            'itech::search',
            compact('posts')
        );
    }

    public function loadMore(Request $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $posts = Post::whereFrontend()
            ->with(['categories' => fn ($q) => $q->whereFrontend()])
            ->latest()
            ->paginate(10, page: $page);

        $html = '';
        foreach ($posts as $post) {
            $html .= view('itech::components.post-item', compact('post'))->render();
        }

        return response()->json([
            'html' => $html,
            'has_more' => $posts->hasMorePages(),
            'next_url' => route('home.load-more', ['page' => $page + 1]),
        ]);
    }

    public function loadPosts(Request $request): JsonResponse
    {
        $type = $request->input('type', 'recent');
        $limit = $request->input('limit', 10);
        $exclude = $request->input('exclude');
        $category = $request->input('category');
        if ($limit > 50) {
            $limit = 50;
        }

        $posts = Post::whereFrontend()
            ->with(['category' => fn ($q) => $q->whereFrontend(), 'creator'])
            ->when(
                $exclude,
                fn ($query) => $query->whereNotIn('id', explode(',', $exclude))
            )
            ->when(
                $category && $category !== 'no',
                fn ($query) => $query->whereHas(
                    'categories',
                    fn ($q) => $q->where('id', $category)->whereFrontend()
                )
            )
            ->when(
                in_array($type, ['popular', 'category']),
                fn ($query) => $query->orderBy('views', 'desc')
            )
            ->when(
                $type === 'recent',
                fn ($query) => $query->latest()
            )
            ->when(
                $type === 'random',
                fn ($query) => $query->inRandomOrder()
            )
            ->limit($limit)
            ->get();

        return response()->json(
            $posts->map(
                fn ($post) => [
                    'id' => $post->id,
                    'title' => $post->title,
                    'url' => $post->getUrl(),
                    'thumbnail' => proxy_image($post->thumbnail),
                    'date' => $post->created_at->format('F d, Y'),
                    'description' => seo_string($post->content, 100),
                    'category' => ($category = $post->category->first()) ? [
                        'id' => $category->id,
                        'name' => $category->name,
                    ] : null,
                    'author' => $post->creator ? [
                        'id' => $post->creator?->id,
                        'name' => $post->creator?->name,
                    ] : null,
                ]
            )
        );
    }
}
