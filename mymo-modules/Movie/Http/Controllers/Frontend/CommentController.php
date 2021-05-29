<?php

namespace Modules\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;
use Modules\Movie\Models\Posts;
use Illuminate\Http\Request;

class CommentController extends FrontendController
{
    public function movieComment($movie_slug, Request $request) {
        $this->validateRequest([
            'content' => 'required',
        ], $request, [
            'content' => trans('app.content')
        ]);
        
        $movie = Movies::where('slug', '=', $movie_slug)
            ->where('status', '=', 1)
            ->findOrFail();
        
        $movie->comments()->create([
            'content' => $request->post('content'),
            'user_id' => \Auth::id(),
        ]);
        
        return response()->json([
            'status' => 'success',
            'redirect' => $request->headers->get('referer'),
        ]);
    }
    
    public function postComment($post_slug, Request $request) {
        $this->validateRequest([
            'content' => 'required',
        ], $request, [
            'content' => trans('app.content')
        ]);
        
        $post = Posts::where('slug', '=', $post_slug)
            ->where('status', '=', 1)
            ->firstOrFail();
    
        $post->comments()->create([
            'content' => $request->post('content'),
            'user_id' => \Auth::id(),
        ]);
        
        return response()->json([
            'status' => 'success',
            'redirect' => $request->headers->get('referer'),
        ]);
    }
}
