<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Actions;

use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;

class EnqueueStyleAction extends Action
{
    public function handle()
    {
        $this->addAction(self::BACKEND_HEADER_ACTION, [$this, 'enqueueStylesHeader']);
        $this->addAction(self::BACKEND_FOOTER_ACTION, [$this, 'enqueueStylesFooter']);
        $this->addAction(self::FRONTEND_HEADER_ACTION, [$this, 'addFrontendHeader']);
    }

    public function enqueueStylesHeader()
    {
        $scripts = get_enqueue_scripts(false);
        $styles = get_enqueue_styles(false);

        foreach ($styles as $style) {
            $href = e($style->get('src')) .'?v='. e($style->get('ver'));
            echo '<link rel="stylesheet" type="text/css" href="'. $href .'">';
        }

        foreach ($scripts as $script) {
            $href = e($script->get('src')) .'?v='. e($script->get('ver'));
            echo '<script src="'. $href .'"></script>';
        }
    }

    public function enqueueStylesFooter()
    {
        $scripts = get_enqueue_scripts(true);
        $styles = get_enqueue_styles(true);

        foreach ($styles as $style) {
            $href = e($style->get('src')) .'?v='. e($style->get('ver'));
            echo '<link rel="stylesheet" type="text/css" href="'. $href .'">';
        }

        foreach ($scripts as $script) {
            $href = e($script->get('src')) .'?v='. e($script->get('ver'));
            echo '<script src="'. $href .'"></script>';
        }
    }

    public function addFrontendHeader()
    {
        $fbAppId = get_config('fb_app_id');
        $googleAnalytics = get_config('google_analytics');
        $scripts = HookAction::getEnqueueFrontendScripts();
        $styles = HookAction::getEnqueueFrontendStyles();

        echo e(view('cms::items.frontend_header', compact(
            'fbAppId',
            'googleAnalytics',
            'scripts',
            'styles'
        )));
    }

    public function addRecaptchaForm()
    {
        $this->addAction('auth_form', [$this, 'recaptchaRender']);
    }

    public function recaptchaRender()
    {
        $recaptcha = get_configs([
            'google_recaptcha',
            'google_recaptcha_key',
        ]);

        if ($recaptcha['google_recaptcha'] == 1) {
            echo view('cms::components.frontend.recaptcha', compact(
                'recaptcha'
            ));
        }
    }
}
