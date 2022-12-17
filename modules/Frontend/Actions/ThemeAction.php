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

use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Support\DefaultPageBlock;
use Juzaweb\CMS\Support\DefaultWidget;
use Juzaweb\Frontend\Http\Controllers\AjaxController;
use TwigBridge\Facade\Twig;

class ThemeAction extends Action
{
    protected string $currentTheme;

    protected array $register = [];

    public function __construct()
    {
        parent::__construct();
        $this->currentTheme = jw_current_theme();
        $this->register = ThemeLoader::getRegister($this->currentTheme);
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

        if (config('juzaweb.adminbar.enable')) {
            HookAction::addAction(Action::FRONTEND_AFTER_BODY, [$this, 'addThemeHeader']);
        }

        HookAction::addAction(Action::INIT_ACTION, [$this, 'templates']);
        HookAction::addAction(
            Action::FRONTEND_INIT,
            [$this, 'addProfilePages']
        );

        $this->addAction(Action::FRONTEND_INIT, [$this, 'addFrontendAjax']);
    }

    public function postTypes()
    {
        $types = $this->getRegister('post_types');
        foreach ($types as $key => $type) {
            $this->hookAction->registerPostType($key, $type);
        }

        $thumbnailSizes = $this->getRegister('thumbnail_sizes');
        foreach ($thumbnailSizes as $postType => $size) {
            $this->hookAction->addThumbnailSizes($postType, $size);
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
        $version = ThemeLoader::getVersion($this->currentTheme);

        if ($styles) {
            foreach ($styles['js'] ?? [] as $index => $js) {
                HookAction::enqueueFrontendScript('main-' . $index, $js, $version);
            }

            foreach ($styles['css'] ?? [] as $index => $css) {
                HookAction::enqueueFrontendStyle('main-' . $index, $css, $version);
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

    public function templates()
    {
        $templates = $this->getRegister('templates');

        foreach ($templates as $key => $template) {
            HookAction::registerThemeTemplate(
                $key,
                $template
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
            HookAction::registerNavMenus(
                [
                    $key => $item['label']
                ]
            );
        }
    }

    public function addBodyClass()
    {
        $bodyClass = $this->getRegister('body_class');
        if ($bodyClass) {
            $this->addFilter(
                'theme.body_class',
                function ($class) use ($bodyClass) {
                    return $class . ' ' . $bodyClass;
                }
            );
        }
    }

    public function appendHeader()
    {
        $append = $this->getRegister('append_header');
        if ($append) {
            $this->addAction(
                'theme.header',
                function () use ($append) {
                    echo e(Twig::display($append));
                }
            );
        }
    }

    public function addThemeHeader()
    {
        if (is_admin()) {
            echo e(view('cms::frontend.admin_bar'));
        }
    }

    public function addProfilePages()
    {
        HookAction::registerProfilePage(
            'index',
            [
                'title' => trans('cms::app.profile'),
            ]
        );

        HookAction::registerProfilePage(
            'change_password',
            [
                'title' => trans('cms::app.change_password'),
            ]
        );
    }

    public function addFrontendAjax()
    {
        if (!$support = $this->getRegister('support')) {
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

            $this->hookAction->registerFrontendAjax(
                'unlike',
                [
                    'callback' => [AjaxController::class, 'unlike'],
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

    protected function getRegister($key, $default = [])
    {
        return Arr::get($this->register, $key, $default);
    }
}
