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
            $page = $this->postRepository->withFilters(['id' => $pageId])->first();

            if ($page) {
                return App::call(PageController::class.'@detail', ['id' => $page]);
            }
        }

        return $this->handlePage($request);
    }

    protected function handlePage(Request $request)
    {
        $config = get_configs(['title', 'description', 'banner']);

        $view = $this->getViewPage();

        $posts = Post::selectFrontendBuilder()
            ->orderBy('id', 'DESC')
            ->paginate(get_config('posts_per_page', 12));

        $page = PostResourceCollection::make($posts)->response()->getData(true);

        $params = $config;
        $params['page'] = $page;

        return apply_filters(
            'theme.page.home.handle',
            $this->view($view, $params),
            $params
        );
    }

    protected function getViewPage(): string
    {
        return 'theme::index';
    }
}
