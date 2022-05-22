<?php

namespace Juzaweb\Frontend\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Http\Controllers\FrontendController;

class HomeController extends FrontendController
{
    public function index(Request $request)
    {
        do_action('theme.home.index');

        if ($pageId = jw_home_page()) {
            return App::call('Juzaweb\Frontend\Http\Controllers\PageController@detail', ['id' => $pageId]);
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
            ->paginate(
                get_config('posts_per_page', 12)
            );

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
