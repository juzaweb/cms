<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Theme\Actions;

use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;
use Theme\Blocks\BannerBlock;
use Theme\Widgets\BannerWidget;

class ThemeAction extends Action
{
    public function handle()
    {
        $this->addAction(Action::JUZAWEB_INIT_ACTION, [
            $this,
            'registerPageBlocks'
        ]);

        $this->addAction(Action::JUZAWEB_INIT_ACTION, [
            $this,
            'registerTemplates'
        ]);

        $this->addAction(Action::JUZAWEB_INIT_ACTION, [
            $this,
            'registerSidebars'
        ]);

        $this->addAction(Action::WIDGETS_INIT, [
            $this,
            'registerWidgets'
        ]);

        $this->addAction(Action::FRONTEND_CALL_ACTION, [
            $this,
            'registerStyles'
        ]);
    }

    public function registerNavMenu()
    {
        HookAction::registerNavMenus([
            'primary' => trans('theme::content.primary_menu'),
        ]);
    }

    public function registerWidgets()
    {
        HookAction::registerWidget('banner', [
            'label' => trans('theme::content.banner'),
            'description' => trans('theme::content.banner'),
            'widget' => new BannerWidget(),
        ]);
    }

    public function registerSidebars()
    {
        HookAction::registerSidebar('sidebar', [
            'label' => trans('theme::content.sidebar'),
            'description' => trans('theme::content.sidebar'),
        ]);
    }

    public function registerPageBlocks()
    {
        HookAction::registerPageBlock('sidebar_banner', [
            'label' => trans('theme::content.sidebar_banner'),
            'block' => new BannerBlock()
        ]);
    }

    public function registerTemplates()
    {
        HookAction::registerThemeTemplate('home', [
            'name' => trans('juzaweb::app.home'),
            'view' => 'templates.home'
        ]);

        HookAction::registerThemeTemplate('post', [
            'name' => trans('juzaweb::app.post'),
            'view' => 'templates.post'
        ]);
    }

    public function registerStyles()
    {
        HookAction::enqueueFrontendScript('main', 'assets/js/main.js');
        HookAction::enqueueFrontendStyle('main', 'assets/css/main.css');
    }
}
