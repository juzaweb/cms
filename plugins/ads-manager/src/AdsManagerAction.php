<?php

namespace Juzaweb\AdsManager;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\AdsManager\Models\Ads;
use Juzaweb\Backend\Facades\HookAction;

class AdsManagerAction extends Action
{
    public function handle()
    {
        $this->addFilter('posts.get_content', [$this, 'addAdsPost']);
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addAdminMenus']);
    }

    public function addAdminMenus()
    {
        HookAction::registerAdminPage(
            'banner-ads',
            [
                'title' => trans('juad::content.banner_ads'),
                'menu' => [
                    'icon' => 'fa fa-file',
                    'position' => 30,
                ]
            ]
        );
    }

    public function addAdsPost($content)
    {
        $botAds = Ads::where('position', '=', 'post_footer')
            ->whereActive(1)
            ->get(['body']);

        foreach ($botAds as $topAd) {
            $content .= $topAd->body;
        }

        $str = '';
        $topAds = Ads::where('position', '=', 'post_header')
            ->whereActive(1)
            ->get(['body']);
        foreach ($topAds as $topAd) {
            $str .= $topAd->body;
        }

        return $str . $content;
    }
}
