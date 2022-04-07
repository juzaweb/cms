<?php

namespace Juzaweb\Story\Http\Controllers;

use Juzaweb\CMS\Http\Controllers\BackendController;

class StoryController extends BackendController
{
    public function index()
    {
        //

        return view('just::index', [
            'title' => 'Title Page',
        ]);
    }
}
