<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Controllers\API;

use Illuminate\Http\Request;
use Juzaweb\Backend\Http\Resources\PostCollection;
use Juzaweb\CMS\Http\Controllers\ApiController;
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

        return new PostCollection($rows);
    }

    public function show(Request $request, $type, $id)
    {
        $post = Post::createFrontendBuilder()
            ->where('type', '=', $type)
            ->where('id', '=', $id)
            ->firstOrFail();

        return new PostResource($post);
    }
}
