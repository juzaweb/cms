<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Actions;

use Illuminate\Http\Request;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\PostRating;

class FrontendAction extends Action
{
    public function handle()
    {
        HookAction::registerFrontendAjax(
            'rating',
            [
                'callback' => [app(FrontendAction::class), 'rating'],
                'method' => 'post',
            ]
        );
    }

    public function rating(Request $request)
    {
        $post = $request->post('post_id');
        $post = Post::createFrontendBuilder()
            ->where('id', '=', $post)
            ->firstOrFail();

        $star = $request->post('star');

        if (empty($star)) {
            return response()->json([
                'status' => 'error',
            ]);
        }

        $clientIp = get_client_ip();

        PostRating::updateOrCreate([
            'post_id' => $post->id,
            'client_ip' => $clientIp,
        ], [
            'star' => $star
        ]);

        $rating = $post->getStarRating();

        $post->update([
            'rating' => $rating,
            'total_rating' => $post->getTotalRating()
        ]);

        return $rating;
    }
}
