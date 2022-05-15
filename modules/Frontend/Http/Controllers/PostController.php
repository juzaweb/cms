<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Http\Resources\CommentResource;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class PostController extends FrontendController
{
    public function index(...$slug)
    {
        if (count($slug) > 1) {
            return $this->detail(...$slug);
        }

        $title = get_config('title');
        $base = $slug[0];
        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));
        $posts = $postType->get('model')::selectFrontendBuilder()
            ->paginate(10);

        $page = PostResource::collection($posts)
            ->response()
            ->getData(true);

        return $this->view(
            'theme::index',
            compact(
                'page',
                'title'
            )
        );
    }

    public function detail(...$slug)
    {
        $base = $slug[0];
        $postSlug = $slug[1];

        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        /**
         * @var Post $postModel
         */
        $postModel = $postType->get('model')::createFrontendBuilder()
            ->where('slug', $postSlug)
            ->firstOrFail();

        event(new PostViewed($postModel));

        $title = $postModel->getTitle();
        $description = $postModel->description;
        $type = $postModel->getPostType('singular');
        $template = get_name_template_part($type, 'single');

        $post = (new PostResource($postModel))->toArray(request());

        $rows = Comment::with(['user'])
            ->where('object_id', '=', $post['id'])
            ->whereApproved()
            ->paginate(10);

        $comments = CommentResource::collection($rows)
            ->response()
            ->getData(true);

        $data = apply_filters(
            "frontend.post_type.{$postType->get('key')}.detail.data",
            compact(
                'title',
                'post',
                'description',
                'comments',
                'slug'
            ),
            $postModel
        );

        return $this->view(
            'theme::template-parts.' . $template,
            $data
        );
    }

    public function comment(Request $request, $slug)
    {
        if (Auth::check()) {
            $this->validate(
                $request,
                [
                    'content' => 'required|max:300',
                ]
            );
        } else {
            $this->validate(
                $request,
                [
                    'name' => 'required|max:100',
                    'email' => 'required|email|max:100',
                    'content' => 'required|max:300',
                ]
            );
        }

        $base = explode('/', $slug)[0];
        $slug = explode('/', $slug)[1];

        $permalink = $this->getPermalinks($base);
        $postType = HookAction::getPostTypes($permalink->get('post_type'));

        if (!in_array('comment', $postType->get('supports', []))) {
            return $this->error(
                [
                    'message' => __('Comments is not supported.'),
                ]
            );
        }

        /**
         * @var Post $post
         */
        $post = $postType->get('model')::createFrontendBuilder()
            ->where('slug', '=', $slug)
            ->firstOrFail();

        $data = $request->all();
        $data['object_type'] = $permalink->get('post_type');
        $data['user_id'] = Auth::id();

        $comment = $post->comments()->create($data);

        do_action('post_type.comment.saved', $comment, $post);

        return $this->success(
            [
                'message' => __('Successful comment. Your comment will be displayed once approved.'),
            ]
        );
    }
}
