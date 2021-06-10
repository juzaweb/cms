<?php

namespace Mymo\Theme\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PageController extends FrontendController
{
    public function index($slug, Request $request)
    {
        $permalinks = $this->getPermalinks();dd($permalinks);
        $base = explode('/', $slug)[0];
        $slug = str_replace($base, '', $slug);

        $permalink = $permalinks->where('base', $base);
        if ($permalink) {
            if ($callback = $permalink->last()->get('callback')) {
                if ($slug) {
                    if ($slug[0] == '/') {
                        $slug = str_replace($slug[0], '', $slug);
                    }

                    return $this->callController($callback, 'content', [
                        'slug' => $slug
                    ]);
                }

                return $this->callController($callback, 'index');
            }
        }

        die('404');
    }
    
    public function detail($slug)
    {
        return view('pages.page.detail');
    }

    protected function callController($callback, $method, $parameters = [])
    {
        return App::call($callback . '@' . $method, $parameters);
    }

    protected function getPermalinks()
    {
        return collect(apply_filters('tadcms.permalinks', []));
    }
}
