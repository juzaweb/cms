<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Juzaweb\Backend\Models\Comment;
use Juzaweb\Backend\Models\Menu;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Facades\HookAction;
use Juzaweb\CMS\Facades\Plugin;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Facades\ThemeConfig;
use Juzaweb\CMS\Support\Theme\BackendMenuBuilder;
use Juzaweb\CMS\Support\Theme\MenuBuilder;
use TwigBridge\Facade\Twig;

function body_class($class = ''): string
{
    $class = trim('jw-theme jw-theme-body '.$class);

    return apply_filters('theme.body_class', $class);
}

function view_render(string $view, array $params = [], ?string $theme = null): ViewContract|Factory|string
{
    return Theme::render($view, $params, $theme);
}

function theme_assets(string $path, string $theme = null): ?string
{
    return ThemeLoader::assets($path, $theme);
}

function theme_asset(string $path, string $theme = null): ?string
{
    return theme_assets($path, $theme);
}

function plugin_asset(string $path, string $plugin = null): ?string
{
    return Plugin::assets($plugin, $path);
}

function plugin_assets(string $path, string $plugin = null): ?string
{
    return Plugin::assets($plugin, $path);
}

if (!function_exists('page_url')) {
    function page_url($slug): string
    {
        return url()->to($slug);
    }
}

/**
 * Get particular theme all information.
 *
 * @param  string  $theme
 * @param  string  $path
 * @return string
 */
function theme_path(string $theme, string $path = ''): string
{
    return ThemeLoader::getThemePath($theme, $path);
}

if (!file_exists('jw_theme_info')) {
    /**
     * Get particular theme all information.
     *
     * @param  string|null  $theme
     * @return null|\Noodlehaus\Config|Collection
     */
    function jw_theme_info(string $theme = null): Collection|\Noodlehaus\Config|null
    {
        if (empty($theme)) {
            return jw_theme_info(jw_current_theme());
        }

        return ThemeLoader::getThemeInfo($theme);
    }
}

if (!function_exists('jw_current_theme')) {
    /**
     * Get current active theme
     *
     * @return string
     */
    function jw_current_theme(): string
    {
        $theme = get_config('theme_statuses', []);
        return Arr::get($theme, 'name', 'default');
    }
}

if (!function_exists('jw_theme_config')) {
    /**
     * Get particular theme all information.
     *
     * @param  string|null  $theme
     * @return Collection
     */
    function jw_theme_config(string $theme = null): Collection
    {
        if (empty($theme)) {
            $theme = jw_current_theme();
        }

        return ThemeLoader::getThemeConfig($theme);
    }
}

if (!function_exists('jw_home_page')) {
    function jw_home_page()
    {
        return apply_filters('get_home_page', get_config('home_page'));
    }
}

if (!function_exists('get_name_template_part')) {
    /**
     * Get template part name.
     *
     * @param  string  $type  // Singular of post
     * @param  string  $slug
     * @param ?string  $name
     * @return string
     */
    function get_name_template_part(string $type, string $slug, ?string $name = null): string
    {
        $name = (string)$name;

        if ($name !== '') {
            $template = "{$slug}-{$name}";
            if (view()->exists(theme_viewname("theme::template-parts.{$template}"))) {
                return $template;
            }
        }

        if ($type != 'post') {
            $template = "{$slug}-{$type}";
            if (view()->exists(theme_viewname("theme::template-parts.{$template}"))) {
                return $template;
            }
        }

        return $slug;
    }
}

if (!function_exists('jw_menu_items')) {
    /**
     * Get menu item in menu
     *
     * @param  Menu  $menu
     * @return Collection
     */
    function jw_menu_items(Menu $menu): Collection
    {
        return $menu->items()
            ->orderBy('num_order', 'ASC')
            ->get();
    }
}

if (!function_exists('jw_page_menu')) {
    function jw_page_menu(?array $args): string
    {
        return trans('cms::app.menu_not_found');
    }
}

if (!function_exists('jw_nav_menu')) {
    function jw_nav_menu(?array $args = [])
    {
        $defaults = [
            'menu' => '',
            'container_before' => '',
            'container_after' => '',
            'fallback_cb' => 'jw_page_menu',
            'theme_location' => '',
            'item_view' => 'theme::components.menu_item',
        ];

        $args = array_merge($defaults, $args);
        if (is_string($args['item_view'])) {
            $args['item_view'] = Twig::loadTemplate(Twig::getTemplateClass($args['item_view']), $args['item_view']);
        }

        $menu = null;

        if ($args['menu']) {
            $menu = $args['menu'];
        }

        if ($args['theme_location']) {
            $menu = get_menu_by_theme_location($args['theme_location']);
        }

        if (is_numeric($menu)) {
            $menu = Menu::find($menu);
        }

        if (empty($menu)) {
            return call_user_func($args['fallback_cb'], $args);
        }

        $items = jw_menu_items($menu);

        return (new MenuBuilder($items, $args))->render();
    }
}

if (!function_exists('jw_nav_backend_menu')) {
    function jw_nav_backend_menu($args = [])
    {
        $defaults = [
            'menu' => '',
            'container_before' => '',
            'container_after' => '',
            'fallback_cb' => 'jw_page_menu',
            'theme_location' => '',
            'item_view' => 'cms::items.menu_item',
        ];

        $args = array_merge($defaults, $args);
        if (is_string($args['item_view'])) {
            $args['item_view'] = view($args['item_view']);
        }

        $menu = null;

        if ($args['menu']) {
            $menu = $args['menu'];
        }

        if ($args['theme_location']) {
            $menu = get_menu_by_theme_location($args['theme_location']);
            $menu = Menu::find($menu);
        }

        if (empty($menu)) {
            return call_user_func($args['fallback_cb'], $args);
        }

        $items = jw_menu_items($menu);
        return (new BackendMenuBuilder($items, $args))->render();
    }
}

if (!function_exists('set_theme_config')) {
    function set_theme_config($key, $value)
    {
        return ThemeConfig::setConfig($key, $value);
    }
}

if (!function_exists('get_theme_config')) {
    function get_theme_config($key, $default = null): null|array|string
    {
        return ThemeConfig::getConfig($key, $default);
    }
}

if (!function_exists('get_theme_mod')) {
    function get_theme_mod($key, $default = null): array|string
    {
        return ThemeConfig::getConfig($key, $default);
    }
}

if (!file_exists('get_menu_by_theme_location')) {
    function get_menu_by_theme_location($location)
    {
        $locations = get_theme_config('nav_location');
        $menuId = $locations[$location] ?? null;
        if ($menuId) {
            return $menuId;
        }

        return null;
    }
}

if (!function_exists('get_logo')) {
    function get_logo($default = null): ?string
    {
        return upload_url(
            get_config('logo'),
            asset($default ?: 'jw-styles/juzaweb/images/logo.png')
        );
    }
}

if (!function_exists('get_icon')) {
    function get_icon($default = null): string
    {
        return upload_url(
            get_config('icon'),
            asset($default ?: 'jw-styles/juzaweb/images/favicon.ico')
        );
    }
}

if (!function_exists('is_home')) {
    function is_home(): bool
    {
        return Route::currentRouteName() == 'home';
    }
}

if (!function_exists('jw_get_sidebar')) {
    function jw_get_sidebar($key): Collection
    {
        return HookAction::getSidebars($key);
    }
}

if (!function_exists('jw_get_widgets_sidebar')) {
    function jw_get_widgets_sidebar($key): Collection
    {
        $content = get_theme_config('sidebar_'.$key, []);

        return collect($content);
    }
}

if (!function_exists('dynamic_sidebar')) {
    function dynamic_sidebar($key): Factory|ViewContract|string
    {
        $sidebar = HookAction::getSidebars($key);
        if (empty($sidebar)) {
            return '';
        }

        $widgets = jw_get_widgets_sidebar($key);

        return view(
            'cms::components.dynamic_sidebar',
            compact(
                'widgets',
                'sidebar'
            )
        );
    }
}

if (!function_exists('dynamic_block')) {
    function dynamic_block($post, $key): ViewContract|Factory
    {
        $data = $post['metas']['block_content'][$key] ?? [];
        $keys = collect($data)->pluck('block')->toArray();

        $blocks = HookAction::getPageBlocks()->filter(
            function ($item) use ($keys) {
                return in_array($item->get('key'), $keys);
            }
        );

        return view(
            'cms::components.dynamic_block',
            compact(
                'data',
                'blocks'
            )
        );
    }
}

if (!function_exists('installed_themes')) {
    function installed_themes(): array
    {
        $themes = ThemeLoader::all();

        return array_keys($themes);
    }
}

if (!function_exists('comment_template')) {
    /**
     * Show comments frontend
     *
     * @param  $post
     * @param  string|null  $view
     * @return ViewContract|Factory|string
     */
    function comment_template($post, string $view = null): ViewContract|Factory|string
    {
        if (empty($view)) {
            $view = 'cms::items.frontend_comment';
        }

        $comments = Comment::with(['user'])
            ->where('object_id', '=', $post['id'])
            ->whereApproved()
            ->paginate(10);

        $total = $comments->total();

        return view_render($view, compact('comments', 'total'));
    }
}

if (!function_exists('theme_header')) {
    function theme_header(): void
    {
        do_action('theme.header');
    }
}

function theme_footer(): void
{
    do_action('theme.footer');
}

function theme_after_body(): void
{
    do_action('theme.after_body');
}

function theme_action($action): void
{
    if (in_array(
        $action,
        [
            'auth_form',
        ]
    )
    ) {
        do_action($action);
    }
}

if (!function_exists('get_template_part')) {
    /**
     * Loads a template part into a template.
     *
     * @param  array|Post  $post
     * @param  string  $slug
     * @param  string|null  $name
     * @param  array  $args
     * @return Factory|View|string
     */
    function get_template_part(
        array|Post $post,
        string $slug,
        ?string $name = null,
        array $args = []
    ): Factory|View|string {
        do_action("get_template_part_{$slug}", $post, $slug, $name, $args);

        $type = $post ? Str::singular($post['type']) : 'none';

        $template = get_name_template_part($type, $slug, $name);

        return view_render("theme::template-parts.{$template}", compact('post'));
    }
}

function paginate_links($data, $view = null, $params = []): ViewContract|Factory|string
{
    if (empty($view)) {
        $view = 'cms::pagination';
    }

    return view_render($view, compact('data', 'params'));
}

function theme_viewname($name)
{
    return $name;
}

function comment_form($post, $view = 'cms::comment_form'): ViewContract|Factory|string
{
    return view_render($view, compact('post'));
}

function get_locale(): string
{
    return app()->getLocale();
}

function home_url(): string
{
    return '/';
}

function share_url($social, $url, $text = null): string
{
    $url = urlencode($url);
    $text = urlencode($text);

    return match ($social) {
        'facebook' => "https://www.facebook.com/sharer.php?u={$url}",
        'twitter' => "https://twitter.com/intent/tweet?url={$url}&text={$text}",
        'telegram' => "https://t.me/share/url?url={$url}&text={$text}",
        'linkedin' => "https://www.linkedin.com/sharing/share-offsite/?url={$url}",
        'pinterest' => "https://pinterest.com/pin/create/button/?url={$url}&description={$text}",
        default => '',
    };
}

if (!function_exists('get_thumbnail_size')) {
    /**
     * Get thumbnail size
     *
     * @param  string  $postType
     * @param  array|null  $thumbnailSizes
     * @return array{width: string,height:string}
     */
    function get_thumbnail_size(string $postType, ?array $thumbnailSizes = null): array
    {
        $thumbnailSizes = $thumbnailSizes ?: HookAction::getThumbnailSizes()->toArray();
        $width = get_theme_config("thumbnail_sizes")[$postType]['width']
            ?? $thumbnailSizes[$postType][array_key_first($thumbnailSizes[$postType] ?? [])]['width']
            ?? '241';
        $height = get_theme_config("thumbnail_sizes")[$postType]['height']
            ?? $thumbnailSizes[$postType][array_key_first($thumbnailSizes[$postType] ?? [])]['height']
            ?? '241';

        return compact('width', 'height');
    }
}

if (!function_exists('get_media_image_with_size')) {
    function get_media_image_with_size(string $path, string $size, string $type = 'url'): ?string
    {
        $filename = File::name($path);

        $path = str_replace($filename, "{$filename}_{$size}", $path);

        return Storage::disk(config('juzaweb.filemanager.disk'))->{$type}($path);
    }
}

if (!function_exists('has_media_image_size')) {
    function has_media_image_size(string $path, string $size): bool
    {
        $filename = File::name($path);

        $path = str_replace($filename, "{$filename}_{$size}", $path);

        return Storage::disk(config('juzaweb.filemanager.disk'))->exists($path);
    }
}
