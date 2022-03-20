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

use Illuminate\Support\Arr;
use Juzaweb\Abstracts\Action;
use Juzaweb\Backend\Facades\HookAction;
use Juzaweb\Facades\Theme;
use Juzaweb\Support\DefaultPageBlock;
use Juzaweb\Support\DefaultWidget;
use TwigBridge\Facade\Twig;

class ThemeAction extends Action
{
    protected $currentTheme;
    protected $register = [];

    public function __construct()
    {
        $this->currentTheme = jw_current_theme();
        $this->register = Theme::getRegister($this->currentTheme);
    }

    public function handle()
    {
        HookAction::addAction(Action::INIT_ACTION, [$this, 'postTypes']);
        HookAction::addAction(Action::INIT_ACTION, [$this, 'resources']);
        HookAction::addAction(Action::FRONTEND_CALL_ACTION, [$this, 'styles']);
        HookAction::addAction(Action::INIT_ACTION, [$this, 'sidebars']);
        HookAction::addAction(Action::WIDGETS_INIT, [$this, 'widgets']);
        HookAction::addAction(Action::INIT_ACTION, [$this, 'navMenus']);
        HookAction::addAction(Action::FRONTEND_CALL_ACTION, [$this, 'addBodyClass']);
        HookAction::addAction(Action::FRONTEND_CALL_ACTION, [$this, 'appendHeader']);
        HookAction::addAction(Action::BLOCKS_INIT, [$this, 'blocks']);
        HookAction::addAction(Action::INIT_ACTION, [$this, 'settingFields']);
    }

    public function postTypes()
    {
        $types = $this->getRegister('post_types');
        foreach ($types as $key => $type) {
            HookAction::registerPostType($key, $type);
        }
    }

    public function resources()
    {
        $resources = $this->getRegister('resources');
        foreach ($resources as $key => $resource) {
            $postType = $resource['post_type'] ?? null;
            HookAction::registerResource($key, $postType, $resource);
        }
    }

    public function styles()
    {
        $styles = $this->getRegister('styles');
        $version = Theme::getVersion($this->currentTheme);

        if ($styles) {
            foreach ($styles['js'] ?? [] as $index => $js) {
                HookAction::enqueueFrontendScript('main-' . $index, $js, $version);
            }

            foreach ($styles['css'] ?? [] as $index => $css) {
                HookAction::enqueueFrontendStyle('main' . $index, $css, $version);
            }
        }
    }

    public function sidebars()
    {
        $sidebars = $this->getRegister('sidebars');
        foreach ($sidebars as $key => $sidebar) {
            HookAction::registerSidebar($key, $sidebar);
        }
    }

    public function widgets()
    {
        $widgets = $this->getRegister('widgets');
        $keys = array_keys($widgets);

        foreach ($widgets as $key => $widget) {
            $widget['widget'] = new DefaultWidget(
                $this->currentTheme,
                $key,
                $widget
            );

            HookAction::registerWidget(
                $key,
                $widget
            );
        }

        $widgetDefaults = [
            'tags' => [
                'label' => trans('cms::app.tags'),
                'description' => trans('cms::app.list_post_tags'),
                'view' => view()->exists(theme_viewname('theme::components.widgets.tags'))
                    ? 'theme::components.widgets.tags'
                    : 'cms::frontend.widgets.tags',
                'form' => 'cms::data.widgets.tags',
            ],
            'html' => [
                'label' => trans('cms::app.html'),
                'description' => trans('cms::app.html'),
                'view' => view()->exists(theme_viewname('theme::components.widgets.html'))
                    ? 'theme::components.widgets.html'
                    : 'cms::frontend.widgets.html',
                'form' => 'cms::data.widgets.html',
            ]
        ];

        foreach ($widgetDefaults as $key => $widget) {
            if (in_array($key, $keys)) {
                continue;
            }

            $widget['widget'] = new DefaultWidget(
                $this->currentTheme,
                $key,
                $widget
            );

            HookAction::registerWidget($key, $widget);
        }
    }

    public function blocks()
    {
        $blocks = $this->getRegister('blocks');
        $theme = jw_current_theme();

        foreach ($blocks as $key => $block) {
            $block['key'] = $key;
            $block['view'] = new DefaultPageBlock(
                $block,
                $theme
            );

            HookAction::registerPageBlock(
                $key,
                $block
            );
        }
    }

    public function settingFields()
    {
        $fields = $this->getRegister('setting_fields');

        foreach ($fields as $key => $field) {
            HookAction::registerThemeSetting(
                $key,
                Arr::get($field, 'label'),
                $field
            );
        }
    }

    public function navMenus()
    {
        $items = $this->getRegister('nav_menus');
        foreach ($items as $key => $item) {
            HookAction::registerNavMenus([
                $key => $item['label']
            ]);
        }
    }

    public function addBodyClass()
    {
        $bodyClass = $this->getRegister('body_class');
        if ($bodyClass) {
            $this->addFilter('theme.body_class', function ($class) use ($bodyClass) {
                return $class . ' ' . $bodyClass;
            });
        }
    }

    public function appendHeader()
    {
        $append = $this->getRegister('append_header');
        if ($append) {
            $this->addAction('theme.header', function () use ($append) {
                echo e(Twig::display($append));
            });
        }
    }

    protected function getRegister($key)
    {
        return Arr::get($this->register, $key, []);
    }
}
