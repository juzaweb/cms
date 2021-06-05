<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Plugins\Movie\Models\Movie\MovieRating;
use Plugins\Movie\Models\Movie\Movies;
use Illuminate\Http\Request;

class RatingController extends FrontendController
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
        
        $client_ip = get_client_ip();
        
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
