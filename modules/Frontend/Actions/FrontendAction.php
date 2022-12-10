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

class FrontendAction extends Action
{
    public function handle()
    {
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
        $this->addAction(self::FRONTEND_FOOTER_ACTION, [$this, 'addFrontendFooter']);
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

    public function addFrontendFooter()
    {
        echo e(view('cms::items.frontend_footer'));
    }
}
