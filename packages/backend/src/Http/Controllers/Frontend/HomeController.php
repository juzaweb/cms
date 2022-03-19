<?php

namespace Juzaweb\Backend\Http\Controllers\Frontend;

use Juzaweb\Http\Controllers\FrontendController;
use Illuminate\Support\Facades\App;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Illuminate\Http\Request;

class HomeController extends FrontendController
{
    public function index(Request $request)
    {
        do_action('theme.home.index');

        if ($pageId = jw_home_page()) {
            return App::call('Juzaweb\Backend\Http\Controllers\Frontend\PageController@detail', ['id' => $pageId]);
        }

        return $this->handlePage($request);
    }

    protected function handlePage($request)
    {
        $config = get_configs(['title', 'description']);
        $view = $this->getViewPage();
        $posts = Post::selectFrontendBuilder()
            ->whereType('posts')
            ->orderBy('id', 'DESC')
            ->paginate(10);

        $page = PostResource::collection($posts)->response()->getData(true);

        $params = [
            'title' => $config['title'],
            'description' => $config['description'],
            'page' => $page,
        ];

        return apply_filters(
            'theme.page.home.handle',
            $this->view($view, $params),
            $params
        );
    }

    protected function getViewPage()
    {
        $view = 'theme::index';

        return $view;
    }
}
