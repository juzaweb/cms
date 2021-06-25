<?php

namespace Mymo\Frontend\Controllers;

class PostController extends FrontendController
{
    public function index()
    {
        return view('pages.post.index');
    }
    
    public function detail($slug)
    {
        return view('pages.post.detail');
    }
}
