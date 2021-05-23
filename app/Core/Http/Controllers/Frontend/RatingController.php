<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Models\Movie\MovieRating;
use App\Core\Models\Movie\Movies;
use App\Core\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function setRating($slug, Request $request) {
        $movie = Movies::where('slug', '=', $slug)
            ->where('status', '=', 1)
            ->firstOrFail(['id']);
        
        $start = $request->post('value');
        if (empty($start)) {
            return response()->json([
                'status' => 'error',
            ]);
        }
        
        $client_ip = get_ip_client();
        
        $model = MovieRating::firstOrNew([
            'movie_id' => $movie->id,
            'client_ip' => $client_ip,
        ]);
        
        $model->movie_id = $movie->id;
        $model->client_ip = $client_ip;
        $model->start = $start;
        $model->save();
        
        return $movie->getStarRating();
    }
}
