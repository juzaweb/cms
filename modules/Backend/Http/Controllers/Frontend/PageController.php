<?php

namespace Juzaweb\Backend\Http\Controllers\Frontend;

use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\CMS\Facades\Theme;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Noodlehaus\Config;

class PageController extends FrontendController
{
    public function index(Request $request, ...$slug)
    {
        $pageSlug = $this->getPageSlug($slug);
        $page = Post::findBySlugOrFail($pageSlug);
        return $this->handlePage($request, $page, $slug);
    }

    public function detail(Request $request, $id)
    {
        $page = Post::find($id);
        if (empty($page)) {
            return abort(404);
        }

        return $this->handlePage($request, $page);
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
        $view = $this->getViewPage($page, $theme);

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

        event(new PostViewed($page));

        return apply_filters(
            'theme.page.handle',
            $this->view($view, $params),
            $page,
            $slug,
            $params
        );
    }

    /**
     * @param Post $page
     * @param Config $themeInfo
     *
     * @return string
     */
    protected function getViewPage(Post $page, $themeInfo)
    {
        if ($template = $page->getMeta('template')) {
            $templates = Theme::getTemplates($themeInfo->get('name'), $template);
            $templateView = $templates['view'] ?? null;

            if ($templateView && view()->exists(theme_viewname($templateView))) {
                $view = $templateView;
            }
        }

        if (empty($view)) {
            $template = get_name_template_part('page', 'single');
            $view = 'theme::template-parts.' . $template;

            if (! view()->exists(theme_viewname($view))) {
                $view = 'theme::template-parts.single';
            }
        }
        
        $view = apply_filters('theme.get_view_page', $view, $page);

        return $view;
    }
}
