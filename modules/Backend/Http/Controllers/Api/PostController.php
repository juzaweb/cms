<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Controllers\Api;

use Illuminate\Http\Request;
use Juzaweb\Http\Controllers\ApiController;
use Juzaweb\Backend\Http\Resources\PostResource;
use Juzaweb\Backend\Models\Post;

class PostController extends ApiController
{
    public function index(Request $request, $type)
    {
        $query = Post::selectFrontendBuilder()
            ->where('type', '=', $type);
        $limit = $this->getQueryLimit();

        $rows = $query->paginate($limit);

        return PostResource::collection($rows);
    }

    public function show(Request $request, $type, $id)
    {
        $post = Post::createFrontendBuilder()
            ->where('type', '=', $type)
            ->where('id', '=', $id)
            ->first();

        return new PostResource($post);
    }
}
