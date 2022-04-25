<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Frontend\Actions;

use Illuminate\Http\Request;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Models\PostRating;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;

class FrontendAction extends Action
{
    public function handle()
    {
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
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
            return response()->json(
                [
                    'status' => 'error',
                ]
            );
        }

        $clientIp = get_client_ip();

        PostRating::updateOrCreate(
            [
                'post_id' => $post->id,
                'client_ip' => $clientIp,
            ],
            [
                'star' => $star
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

    public function addFrontendHeader()
    {
        $fbAppId = get_config('fb_app_id');
        $googleAnalytics = get_config('google_analytics');
        $scripts = HookAction::getEnqueueFrontendScripts();
        $styles = HookAction::getEnqueueFrontendStyles();

        echo e(
            view(
                'cms::items.frontend_header',
                compact(
                    'fbAppId',
                    'googleAnalytics',
                    'scripts',
                    'styles'
                )
            )
        );
    }

    public function addRecaptchaForm()
    {
        $this->addAction('auth_form', [$this, 'recaptchaRender']);
    }

    public function recaptchaRender()
    {
        $recaptcha = get_configs(
            [
                'google_recaptcha',
                'google_recaptcha_key',
            ]
        );

        if ($recaptcha['google_recaptcha'] == 1) {
            echo view(
                'cms::components.frontend.recaptcha',
                compact(
                    'recaptcha'
                )
            );
        }
    }
}
