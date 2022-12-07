<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Juzaweb\Backend\Events\PostViewed;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Facades\ThemeLoader;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class PageController extends FrontendController
{
    protected array $themeRegister;

    public function index(Request $request, ...$slug)
    {
        $pageSlug = $this->getPageSlug($slug);

        $page = Post::createFrontendDetailBuilder()
            ->where('slug', '=', $pageSlug)
            ->firstOrFail();

        return $this->handlePage($request, $page, $slug);
    }

    public function detail(Request $request, $id)
    {
        $page = Post::createFrontendDetailBuilder()->findOrFail($id);

        return $this->handlePage($request, $page);
    }

    protected function getPageSlug($slug)
    {
        return apply_filters('theme.page_slug', $slug[0], $slug);
    }

    protected function handlePage(Request $request, Post $page, array $slug = [])
    {
        $theme = jw_theme_info();
        $params = $this->getPageParams($page, $slug, $request);

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

    protected function getPageParams($page, $slug, $request): array
    {
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

        if ($template = $page->getMeta('template')) {
            if ($data = $this->getThemeRegister("templates.{$template}.data")) {
                foreach ($data as $key => $item) {
                    $params['page'][$key] = $this->getPageCustomData($item, $params);
                }
            }
        }

        return $params;
    }

    protected function getPageCustomData(array $item, array $params)
    {
        global $jw_user;

        switch ($item['type']) {
            case 'post_liked':
                $query = Post::createFrontendBuilder();

                if (isset($item['post_type'])) {
                    $query->where('type', '=', $item['post_type']);
                }

                $query->whereHas(
                    'likes',
                    function ($q) use ($jw_user, $item) {
                        $q->where("{$q->getModel()->getTable()}.user_id", '=', $jw_user->id);
                    }
                );

                $paginate = $query->paginate(get_config('posts_per_page', 12))
                    ->appends(request()->query());

                return PostResourceCollection::make($paginate)->response()->getData(true);
            case 'popular_posts':
                return get_popular_posts(
                    $item['post_type'] ?? null,
                    $params['post'],
                    $item['limit'] ?? 5
                );
            case 'related_posts':
                return get_related_posts(
                    $params['post'],
                    $item['limit'] ?? 5,
                    $item['taxonomy'] ?? null
                );
            case 'previous_post':
                return get_previous_post($params['post']);
            case 'next_post':
                return get_next_post($params['post']);
        }

        return null;
    }

    protected function getViewPage(Post $page, $themeInfo, array $params = []): string
    {
        /* Get view by template */
        if ($template = $page->getMeta('template')) {
            $templates = ThemeLoader::getTemplates($themeInfo->get('name'), $template);
            $templateView = Arr::get($templates, 'view', "theme::templates.{$template}");

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

    protected function getThemeRegister(string $key = null): ?array
    {
        if (!isset($this->themeRegister)) {
            $this->themeRegister = ThemeLoader::getRegister(jw_current_theme());
        }

        if ($key) {
            return Arr::get($this->themeRegister, $key);
        }

        return $this->themeRegister;
    }
}
