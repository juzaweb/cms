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

use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\CMS\Contracts\LocalThemeRepositoryContract;
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

    public function __construct(protected LocalThemeRepositoryContract $themeRepository)
    {
        parent::__construct();
        $this->currentTheme = jw_current_theme();
        $this->register = ThemeLoader::getRegister($this->currentTheme);

        if ($this->themeRepository->currentTheme()->getTemplate() == 'inertia') {
            $this->addFrontendAjaxForInertiaTemplate();
        }
    }

    public function handle(): void
    {
        HookAction::addAction(Action::INIT_ACTION, [$this, 'postTypes']);
        HookAction::addAction(Action::INIT_ACTION, [$this, 'taxonomies']);
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

    public function postTypes(): void
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

    public function taxonomies(): void
    {
        $types = $this->getRegister('taxonomies');
        foreach ($types as $key => $type) {
            $this->hookAction->registerTaxonomy($key, $type['post_types'], $type);
        }
    }

    public function resources(): void
    {
        $resources = $this->getRegister('resources');
        foreach ($resources as $key => $resource) {
            $postType = $resource['post_type'] ?? null;
            HookAction::registerResource($key, $postType, $resource);
        }
    }

    public function styles(): void
    {
        $styles = $this->getRegister('styles');
        $version = ThemeLoader::getVersion($this->currentTheme);

        if ($styles) {
            $index = 0;
            foreach ($styles['js'] ?? [] as $key => $js) {
                $inFooter = false;
                $options = [];
                if (is_array($js)) {
                    $inFooter = Arr::get($js, 'footer', false);
                    $options = $js;
                    $js = $key;
                }

                HookAction::enqueueFrontendScript('js-main-' . $index, $js, $version, $inFooter, $options);
                $index++;
            }

            $index = 0;
            foreach ($styles['css'] ?? [] as $key => $css) {
                /*if (!is_url($css)) {
                    continue;
                }*/
                $inFooter = false;
                if (is_array($css)) {
                    $inFooter = Arr::get($css, 'footer', false);
                    $css = $key;
                }

                HookAction::enqueueFrontendStyle('css-main-' . $index, $css, $version, $inFooter);
                $index++;
            }
        }
    }

    public function sidebars(): void
    {
        $sidebars = $this->getRegister('sidebars');
        foreach ($sidebars as $key => $sidebar) {
            HookAction::registerSidebar($key, $sidebar);
        }
    }

    public function widgets(): void
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

    public function blocks(): void
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

    public function templates(): void
    {
        $templates = $this->getRegister('templates');

        foreach ($templates as $key => $template) {
            HookAction::registerThemeTemplate(
                $key,
                $template
            );
        }
    }

    public function settingFields(): void
    {
        $fields = $this->getRegister('configs');

        foreach ($fields as $key => $field) {
            if (is_numeric($key)) {
                $key = $field['name'];
            }

            HookAction::registerThemeSetting(
                $key,
                Arr::get($field, 'label'),
                $field
            );
        }
    }

    public function navMenus(): void
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

    public function addBodyClass(): void
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

    public function appendHeader(): void
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

    public function addThemeHeader(): void
    {
        if (is_admin()) {
            echo e(view('cms::frontend.admin_bar'));
        }
    }

    public function addProfilePages(): void
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

    public function addFrontendAjax(): void
    {
        if (!$support = $this->getRegister('support')) {
            return;
        }

        if (in_array('like', $support, true)) {
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

        if (in_array('rating', $support, true)) {
            $this->hookAction->registerFrontendAjax(
                'rating',
                [
                    'callback' => [AjaxController::class, 'rating'],
                    'method' => 'post',
                ]
            );
        }
    }

    public function addFrontendAjaxForInertiaTemplate(): void
    {
        $this->hookAction->registerFrontendAjax(
            'related-posts',
            [
                'callback' => [AjaxController::class, 'relatedPosts'],
            ]
        );

        $this->hookAction->registerFrontendAjax(
            'menu',
            [
                'callback' => [AjaxController::class, 'getMenuItems'],
            ]
        );

        $this->hookAction->registerFrontendAjax(
            'sidebar',
            [
                'callback' => [AjaxController::class, 'sidebar'],
            ]
        );
    }

    protected function getRegister($key, $default = [])
    {
        return Arr::get($this->register, $key, $default);
    }
}
