<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support\Creators;

use Juzaweb\Backend\Models\Post;
use Juzaweb\CMS\Contracts\PostCreatorContract;

class PostCreator implements PostCreatorContract
{
    public function create(array $data, array $options = []): Post
    {

    }
}
