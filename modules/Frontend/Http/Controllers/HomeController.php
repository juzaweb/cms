<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Juzaweb\Backend\Http\Resources\PostResourceCollection;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Backend\Repositories\PostRepository;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{
    public function __construct(protected PostRepository $postRepository)
    {
    }

    public function index(Request $request)
    {
        do_action('theme.home.index');

        if ($pageId = jw_home_page()) {
            $page = $this->postRepository->scopeQuery(fn($q) => $q->where(['id' => $pageId]))->first();

            if ($page) {
                return App::call([PageController::class, 'detail'], ['id' => $page]);
            }
        }

        return $this->handlePage($request);
    }

    protected function handlePage(Request $request)
    {
        $params = $this->getParamsForTemplate();

        return apply_filters('theme.page.home.handle', $this->view($this->getViewPage(), $params), $params);
    }

    protected function getParamsForTemplate(): array
    {
        $posts = $this->postRepository
            ->withSorts(['id' => 'DESC'])
            ->frontendListPaginate(get_config('posts_per_page', 12));

        $params = get_configs(['title', 'description', 'banner']);

        if ($this->template == 'twig') {
            $page = PostResourceCollection::make($posts)->response()->getData(true);

            $params['page'] = $page;

            return $params;
        }

        $params['posts'] = $posts;

        return $params;
    }

    protected function getViewPage(): string
    {
        return 'theme::index';
    }
}
