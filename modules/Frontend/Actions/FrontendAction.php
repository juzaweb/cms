<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Frontend\Actions;

use Illuminate\Support\Facades\File;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\ThemeLoader;

class FrontendAction extends Action
{
    public function handle(): void
    {
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
        $this->addAction(self::FRONTEND_FOOTER_ACTION, [$this, 'addFrontendFooter']);
        //$this->addAction('theme.after_body', [$this, 'addThemeBody']);
    }

    public function addFrontendHeader(): void
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

    public function addFrontendFooter(): void
    {
        $scripts = HookAction::getEnqueueFrontendScripts(true);
        $styles = HookAction::getEnqueueFrontendStyles(true);

        echo e(view('cms::items.frontend_footer', compact('scripts', 'styles')));
    }

    public function addThemeBody(): void
    {
        $str = '';
        $theme = jw_current_theme();
        $styles = ThemeLoader::getRegister($theme)['styles'] ?? [];

        foreach ($styles['css'] ?? [] as $css) {
            if (is_url($css)) {
                continue;
            }

            $str .= File::get(public_path("jw-styles/themes/{$theme}/{$css}"));
        }

        if ($str) {
            echo '<style>'.$str.'</style>';
        }
    }
}
