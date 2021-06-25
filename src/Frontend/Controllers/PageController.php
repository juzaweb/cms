<?php

namespace Mymo\Frontend\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class PageController extends FrontendController
{
    public function index()
    {

    }

    public function detail($slug)
    {
        return view('pages.page.detail');
    }

    protected function callController($callback, $method, $parameters = [])
    {
        return App::call($callback . '@' . $method, $parameters);
    }
}
