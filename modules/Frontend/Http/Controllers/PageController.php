<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Route;
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

        /**
         * @var Post $page
         */
        $page = Post::createFrontendDetailBuilder()
            ->where('slug', '=', $pageSlug)
            ->firstOrFail();

        return $this->handlePage($request, $page, $slug);
    }

    public function detail(Request $request, $id)
    {
        if (!$id instanceof Post) {
            /**
             * @var Post $page
             */
            $page = Post::createFrontendDetailBuilder()->findOrFail($page);

            return $this->handlePage($request, $page);
        }

        return $this->handlePage($request, $id);
    }

    protected function getPageSlug($slug)
    {
        return apply_filters('theme.page_slug', $slug[0], $slug);
    }

    protected function handlePage(Request $request, Post $page, array $slug = [])
    {
        /* Redirect home page */
        if (get_config('show_on_front') && $page->id == get_config('home_page')) {
            if (Route::getCurrentRoute()->getName() != 'home') {
                return redirect()->route('home', [], 301);
            }
        }

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

    /**
     * @param Post $page
     * @param array $slug
     * @param $request
     * @return array
     */
    protected function getPageParams(Post $page, array $slug, $request): array
    {
        $image = $page->thumbnail ? upload_url($page->thumbnail) : null;

        if (is_home()) {
            $config = get_configs(['title', 'description']);

            $params = [
                'post' => (new PostResource($page))->toArray($request),
                'title' => $config['title'],
                'description' => $config['description'],
                'slug' => $slug,
                'image' => $image,
            ];
        } else {
            $params = [
                'post' => (new PostResource($page))->toArray($request),
                'title' => $page->title,
                'description' => $page->description,
                'slug' => $slug,
                'image' => $image,
            ];
        }

        if ($template = $page->getMeta('template')) {
            if ($data = $this->getThemeRegister("templates.{$template}.data")) {
                foreach ($data as $key => $item) {
                    $params['page'][$key] = $this->getPageCustomData($item, $params);
                }
            }
        }

        $data = apply_filters(
            "frontend.post_type.detail.data",
            $params,
            $page
        );

        return apply_filters(
            "frontend.post_type.pages.detail.data",
            $data,
            $page
        );
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

            if (!view()->exists(theme_viewname($view))) {
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
