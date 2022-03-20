<?php

namespace Juzaweb\Backend\Http\Controllers\Backend;

use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Backend\Models\Post;
use Juzaweb\Traits\PostTypeController;

class PostController extends BackendController
{
    use PostTypeController;

    protected $viewPrefix = 'cms::backend.post';

    protected function getModel()
    {
        return Post::class;
    }
}
