<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Actions;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\Frontend\Http\Controllers\AjaxController;

class FrontendAction extends Action
{
    public function handle()
    {
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
        $this->addAction(Action::FRONTEND_INIT, [$this, 'addFrontendAjax']);
    }

    public function addFrontendAjax()
    {
        $theme = Theme::find(jw_current_theme());
        if (!$support = $theme->getRegister('support', [])) {
            return;
        }

        if (in_array('like', $support)) {
            $this->hookAction->registerFrontendAjax(
                'like',
                [
                    'callback' => [AjaxController::class, 'like'],
                    'method' => 'post',
                    'auth' => true,
                ]
            );
        }

        if (in_array('rating', $support)) {
            $this->hookAction->registerFrontendAjax(
                'rating',
                [
                    'callback' => [AjaxController::class, 'rating'],
                    'method' => 'post',
                ]
            );
        }
    }

    public function addFrontendHeader()
    {
        $fbAppId = get_config('fb_app_id');
        $googleAnalytics = get_config('google_analytics');
        $scripts = HookAction::getEnqueueFrontendScripts();
        $styles = HookAction::getEnqueueFrontendStyles();
        $bingKey = get_config('bing_verify_key');
        $googleKey = get_config('google_verify_key');

        echo e(
            view(
                'cms::items.frontend_header',
                compact(
                    'fbAppId',
                    'googleAnalytics',
                    'scripts',
                    'styles',
                    'bingKey',
                    'googleKey'
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
