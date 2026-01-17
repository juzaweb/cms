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

use Juzaweb\Modules\Blog\Models\Category;
use Juzaweb\Modules\Blog\Models\Post;
use Juzaweb\Modules\Core\Http\Controllers\ThemeController;
use Juzaweb\Modules\Core\Http\Requests\CommentRequest;

class BlogController extends ThemeController
{
    public function show(string $slug)
    {
        $post = Post::whereFrontend(translationCacheTags: ['post_translations', 'post_translations:' . $slug])
            ->cacheTags(['posts', "posts:{$slug}"])
            ->with(['categories' => fn ($q) => $q->with(['children'])->whereRoot()->whereFrontend()])
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        $prevPost = Post::whereFrontend()
            ->where('id', '<', $post->id)
            ->orderBy('id', 'desc')
            ->first();

        $nextPost = Post::whereFrontend()
            ->where('id', '>', $post->id)
            ->orderBy('id', 'asc')
            ->first();

        $comments = $post->comments()
            ->with(['commented', 'children.commented'])
            ->whereFrontend()
            ->paginate(10);

        return view(
            'itech::blog.show',
            [
                ...compact(
                    'post',
                    'prevPost',
                    'nextPost',
                    'comments'
                ),
                'ogType' => 'article',
                'title' => $post->title,
                'description' => $post->description,
                'image' => $post->thumbnail,
            ]
        );
    }

    public function comment(CommentRequest $request, string $slug)
    {
        $post = Post::whereFrontend()
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        $comment = $request->save($post);
        $comment->created_time = $comment->created_at->diffForHumans();
        $comment->content = nl2br(e($comment->content));

        return $this->success(
            [
                'message' => __('itech::translation.comment_added_successfully'),
                'comment' => $comment,
            ]
        );
    }

    public function category(string $slug)
    {
        $category = Category::whereFrontend()
            ->whereTranslation('slug', $slug)
            ->firstOrFail();

        $posts = Post::whereFrontend()
            ->with(['categories' => fn ($q) => $q->whereRoot()->whereFrontend()])
            ->whereHas(
                'categories',
                fn ($q) => $q->where('id', $category->id)
            )
            ->paginate(10);

        return view(
            'itech::blog.category',
            [
                ...compact(
                    'category',
                    'posts'
                ),
                'title' => $category->name,
                'description' => $category->description,
                'ogType' => 'object',
            ]
        );
    }
}
