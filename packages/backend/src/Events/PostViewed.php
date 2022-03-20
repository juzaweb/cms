<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/laravel-cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Events;

use Juzaweb\Backend\Models\Post;

class PostViewed
{
    public $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }
}
