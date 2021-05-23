<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movie\Movies;
use App\Models\Posts;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
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
