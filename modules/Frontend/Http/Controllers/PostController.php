<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Http\Resources\CommentResource;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Facades\Facades;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Frontend\Http\Requests\CommentRequest;

class PostController extends FrontendController
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    public function index(...$slug): View|Factory|string|Response
    {
        if (count($slug) > 1) {
            return $this->detail(...$slug);
        }

        $title = get_config('title');
        $posts = $this->postRepository->frontendListPaginate(get_config('posts_per_page', 12));

        $posts->appends(request()?->query());

        if ($this->template === 'twig') {
            $page = PostResourceCollection::make($posts)
                ->response()
                ->getData(true);

            return $this->view('theme::index', compact('page', 'title'));
        }

        return $this->view('theme::index', compact('posts', 'title'));
    }

    public function detail(...$slug): View|Factory|string|Response
    {
        do_action("frontend.post_type.detail", $slug);

        $base = Arr::get($slug, 0);
        $postSlug = $this->getPostSlug($slug);
        $permalink = $this->getPermalinks($base);

        do_action(
            "frontend.post_type.{$permalink->get('post_type')}.detail",
            $slug,
            $postSlug,
            $permalink
        );

        $post = $this->postRepository->findBySlug($postSlug, false);
        if ($post === null && count($slug) > 2) {
            $post = $this->postRepository->findBySlug($slug[1]);
        }

        abort_unless(isset($post), 404);

        Facades::$isPostPage = true;

        Facades::$post = $post;

        event(new PostViewed($post));

        $type = $post->getPostType('singular');

        $template = get_name_template_part($type, 'single');

        //$post = (new PostResource($post))->toArray(request());

        return $this->view(
            "theme::template-parts.{$template}",
            $this->getParamDetail($post, $slug, $permalink)
        );
    }

    public function comment(CommentRequest $request, $slug): JsonResponse|RedirectResponse
    {
        $slug = explode('/', $slug);
        $base = Arr::get($slug, 0);
        $slug = $this->getPostSlug($slug);

        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        if (!in_array('comment', $postType->get('supports', []))) {
            return $this->error(
                [
                    'message' => __('Comments is not supported.'),
                ]
            );
        }

        $post = $this->postRepository->findBySlug($slug);
        $data = $request->safe()->toArray();
        $data['object_type'] = $permalink->get('post_type');
        $data['user_id'] = Auth::id();

        $comment = $post->comments()->create($data);

        do_action('post_type.comment.saved', $comment, $post);

        return $this->success(trans('cms::app.comment_success'));
    }

    private function getParamDetail(Post $post, array $slug, Collection $permalink): array
    {
        $title = $post->getTitle();
        $description = $post->description;
        $image = $post->thumbnail ? upload_url($post->thumbnail) : null;
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        $comments = Comment::with(['user'])
            ->cacheFor(config('juzaweb.performance.query_cache.lifetime'))
            ->where(['object_id' => $post['id']])
            ->whereApproved()
            ->paginate(10);

        $data = apply_filters(
            "frontend.post_type.detail.data",
            compact(
                'title',
                'post',
                'description',
                'comments',
                'slug',
                'image'
            ),
            $post
        );

        return apply_filters(
            "frontend.post_type.{$postType->get('key')}.detail.data",
            $data,
            $post
        );
    }

    private function getPostSlug(array $slug): string
    {
        unset($slug[0]);

        return implode('/', $slug);
    }
}
