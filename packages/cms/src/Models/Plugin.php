<?php

namespace Juzaweb\Models;

use Juzaweb\Backend\Models\Post;

class Plugin extends Post
{
    //protected $connection = 'pgsql';
    protected $postType = 'plugins';
}
