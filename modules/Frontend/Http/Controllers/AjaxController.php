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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\PostRating;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Frontend\Http\Requests\LikeRequest;
use Juzaweb\Frontend\Http\Requests\RatingRequest;

class AjaxController extends FrontendController
{
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
            $method = Str::upper($method);
            if ($request->method() != $method) {
                return response('Method is not supported.', 403);
            }
        }

        $callback = $ajax->get('callback');
        if (is_string($callback[0])) {
            return App::call([app($callback[0]), $callback[1]]);
        }

        return App::call($callback);
    }

    public function rating(RatingRequest $request)
    {
        $post = Post::wherePublish()
            ->where('id', '=', $request->post('post_id'))
            ->firstOrFail();

        $clientIp = get_client_ip();
        PostRating::updateOrCreate(
            [
                'post_id' => $post->id,
                'client_ip' => $clientIp,
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
        global $jw_user;

        $post = Post::wherePublish()
            ->where(['id' => $request->input('post_id')])
            ->firstOrFail();

        $post->likes()->firstOrCreate(
            [
                'user_id' => $jw_user->id,
            ],
            [
                'client_ip' => get_client_ip()
            ]
        );

        return $this->success('Like success.');
    }

    public function unlike(LikeRequest $request): JsonResponse|RedirectResponse
    {
        global $jw_user;

        $post = Post::wherePublish()
            ->where(['id' => $request->input('post_id')])
            ->firstOrFail();

        $post->likes()->where(['user_id' => $jw_user->id])->first()?->delete();

        return $this->success('Unlike success.');
    }
}
