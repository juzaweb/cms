<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Movies;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    public function comment($course_id, Request $request) {
        $this->validateRequest([
            'content' => 'required',
        ], $request, [
            'content' => trans('app.content')
        ]);
        
        $movie = Movies::findOrFail($course_id);
        $movie->comments()->create([
            'content' => $request->post('content'),
            'user_id' => \Auth::id(),
        ]);
        
        return response()->json([
            'status' => 'success',
        ]);
    }
}
