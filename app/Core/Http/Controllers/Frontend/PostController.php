<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Models\Posts;
use App\Core\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;

class PostController extends Controller
{
    public function index() {
        $posts = Posts::where('status', '=', 1)
            ->orderBy('id', 'desc')
            ->paginate(5, ['id', 'title', 'slug', 'meta_description']);
        
        return view('post.index', [
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
        
        $this->_setView($info);
        
        return view('post.detail', [
            'title' => $info->meta_title,
            'description' => $info->meta_description,
            'keywords' => $info->keywords,
            'banner' => $info->getThumbnail(false),
            'info' => $info
        ]);
    }
    
    private function _setView(Posts $post) {
        $viewed = Cookie::get('post_viewed');
        if ($viewed) {
            $viewed = json_decode($viewed, true);
        
            if (!in_array($post->id, $viewed)) {
                $post->update([
                    'views' => $post->views + 1,
                ]);
            
                $viewed[] = $post->id;
                Cookie::queue('post_viewed', json_encode($viewed), 1440);
            }
        }
        
        if (empty($viewed)) {
            $post->update([
                'views' => $post->views + 1,
            ]);
            
            $viewed[] = $post->id;
            Cookie::queue('post_viewed', json_encode($viewed), 1440);
        }
    }
}
