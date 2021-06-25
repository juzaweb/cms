<?php

namespace Mymo\Frontend\Controllers;

use Illuminate\Http\Request;

class SearchController extends FrontendController
{
    public function index(Request $request)
    {
        return view('search');
    }
    
    public function ajaxSearch()
    {
    
    }
}
