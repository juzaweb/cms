<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Noodlehaus\Config;

class PageController extends FrontendController
{
    public function index(Request $request, ...$slug)
    {
        $pageSlug = $this->getPageSlug($slug);
        $page = Post::findBySlugOrFail($pageSlug);
        return $this->handlePage($request, $page, $slug);
    }

    protected function getPageSlug($slug)
    {
        return apply_filters('theme.page_slug', $slug[0], $slug);
    }

    protected function handlePage(Request $request, Post $page, array $slug = [])
    {
        /**
         * @var Config $theme
         */
        $theme = jw_theme_info();

        if (is_home()) {
            $config = get_configs(['title', 'description']);

            $params = [
                'post' => (new PostResource($page))->toArray($request),
                'title' => $config['title'],
                'description' => $config['description'],
                'slug' => $slug,
            ];
        } else {
            $params = [
                'post' => (new PostResource($page))->toArray($request),
                'title' => $page->title,
                'description' => $page->description,
                'slug' => $slug,
            ];
        }

        $params = apply_filters('theme.get_params_page', $params, $page);

        $view = $this->getViewPage($page, $theme, $params);

        event(new PostViewed($page));

        /* Add pages filter */
        $result = apply_filters(
            'theme.page.handle',
            $this->view($view, $params),
            $page,
            $slug,
            $params
        );

        /* Add single page filter */
        return apply_filters(
            "theme.page_{$page->id}.handle",
            $result,
            $page,
            $slug,
            $params
        );
    }

    protected function getViewPage(Post $page, $themeInfo, array $params = []): string
    {
        /* Get view by template */
        if ($template = $page->getMeta('template')) {
            $templates = ThemeLoader::getTemplates($themeInfo->get('name'), $template);
            $templateView = $templates['view'] ?? null;

            if ($templateView && view()->exists(theme_viewname($templateView))) {
                $view = $templateView;
            }
        }

        /* Get view default of theme */
        if (empty($view)) {
            $template = get_name_template_part('page', 'single');
            $view = 'theme::template-parts.' . $template;

            if (! view()->exists(theme_viewname($view))) {
                $view = 'theme::template-parts.single';
            }
        }

        return apply_filters('theme.get_view_page', $view, $page, $params);
    }

    public function detail(Request $request, $id)
    {
        $page = Post::findOrFail($id);

        return $this->handlePage($request, $page);
    }
}
