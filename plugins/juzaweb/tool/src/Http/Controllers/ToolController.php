<?php

namespace Juzaweb\Tool\Http\Controllers;

use Juzaweb\Http\Controllers\BackendController;

class ToolController extends BackendController
{
    public function index()
    {
        //

        return view('juto::index', [
            'title' => 'Title Page',
        ]);
    }
}
