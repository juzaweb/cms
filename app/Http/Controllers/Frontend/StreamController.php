<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class StreamController extends Controller
{
    public function image($path) {
        
        if (explode('/', $path)[0] === 'photos') {
            $path = \Storage::disk('uploads')->path($path);
            if (file_exists($path)) {
                return response()->file($path);
            }
            
            return \Image::make();
        }
        
        abort(404);
    }
}
