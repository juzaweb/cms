<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Posts;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index() {
        $posts = Posts::where('status', '=', 1)
            ->orderBy('id', 'desc')
            ->paginate(5, ['id', 'title', 'slug', 'meta_description']);
        
        return view('themes.mymo.post.index', [
            'title' => get_config('blog_title'),
            'description' => get_config('blog_description'),
            'keywords' => get_config('blog_keywords'),
            'banner' => get_config('blog_banner'),
            'posts' => $posts
        ]);
    }
    
    public function detail($slug) {
        $info = Posts::where('status', '=', 1)
            ->where('slug', '=', $slug)
            ->firstOrFail();
        
        return view('themes.mymo.post.detail', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getThumbnail(false),
            'info' => $info
        ]);
    }
}
