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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Models\PostRating;
use Juzaweb\Backend\Repositories\MenuRepository;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\CMS\Support\Theme\MenuBuilder;
use Juzaweb\Frontend\Http\Requests\LikeRequest;
use Juzaweb\Frontend\Http\Requests\RatingRequest;

class AjaxController extends FrontendController
{
    public function __construct(
        protected PostRepository $postRepository,
        protected MenuRepository $menuRepository
    ) {
        //
    }

    public function ajax($key, Request $request)
    {
        $key = str_replace('/', '.', $key);
        $ajax = HookAction::getFrontendAjaxs($key);

        if (empty($ajax)) {
            return response('Ajax function not found.', 404);
        }

        if ($ajax->get('auth') && !Auth::check()) {
            return response('You do not have permission to access this link.', 403);
        }

        if ($method = $ajax->get('method')) {
            if ($request->method() != Str::upper($method)) {
                return response('Method is not supported.', 403);
            }
        }

        $callback = $ajax->get('callback');
        if (is_string($callback[0])) {
            return App::call([app($callback[0]), $callback[1]]);
        }

        return App::call($callback);
    }

    public function rating(RatingRequest $request): float|int
    {
        $post = $this->postRepository->find($request->input('post_id'));

        abort_unless($post->isPublish(), 404);

        PostRating::updateOrCreate(
            [
                'post_id' => $post->id,
                'client_ip' => get_client_ip(),
            ],
            [
                'star' => $request->post('star')
            ]
        );

        $rating = $post->getStarRating();

        $post->update(
            [
                'rating' => $rating,
                'total_rating' => $post->getTotalRating()
            ]
        );

        return $rating;
    }

    public function like(LikeRequest $request): JsonResponse|RedirectResponse
    {
        $post = $this->postRepository->find($request->input('post_id'));

        abort_unless($post->isPublish(), 404);

        $post->likes()->firstOrCreate(
            [
                'user_id' => $request->user()->id,
            ],
            [
                'client_ip' => get_client_ip()
            ]
        );

        return $this->success('Like success.');
    }

    public function unlike(LikeRequest $request): JsonResponse|RedirectResponse
    {
        $post = $this->postRepository->find($request->input('post_id'));

        abort_unless($post->isPublish(), 404);

        $post->likes()->where(['user_id' => $request->user()->id])->first()?->delete();

        return $this->success('Unlike success.');
    }

    public function relatedPosts(Request $request): JsonResponse
    {
        $post = $this->postRepository->findBySlug($request->input('post_slug'), false);
        $limit = $request->input('limit', 10);
        $taxonomy = $request->input('taxonomy', 'categories');

        if ($limit > 100) {
            $limit = 100;
        }

        if ($post === null) {
            return response()->json(['data' => []]);
        }

        $posts = $this->postRepository->getRelatedPosts($post, $taxonomy, $limit);

        return response()->json(
            [
                'data' => PostResourceCollection::make($posts),
            ]
        );
    }

    public function getMenuItems(Request $request): JsonResponse
    {
        $location = $request->input('location');

        $menu = $this->menuRepository->getFrontendDetailByLocation($location);

        if ($menu === null) {
            return response()->json(['items' => []]);
        }

        $items = jw_menu_items($menu);

        return response()->json(
            [
                'items' => (new MenuBuilder($items))->toArray(),
            ]
        );
    }

    public function sidebar(Request $request): JsonResponse
    {
        $sidebar = $request->input('sidebar');

        $config = get_theme_config("sidebar_{$sidebar}", []);

        return response()->json(
            [
                'config' => array_values($config),
            ]
        );
    }
}
