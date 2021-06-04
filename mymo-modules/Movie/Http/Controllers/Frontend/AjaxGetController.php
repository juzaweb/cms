<?php

namespace Modules\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Modules\Movie\Models\Movie\Movies;
use Illuminate\Http\Request;

class AjaxGetController extends FrontendController
{
    public function getMoviesByGenre(Request $request) {
        $genre = $request->get('cat_id');
        $showpost = $request->get('showpost', 12);
        
        $query = Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ]);
    
        $query->where('status', '=', 1);
        $query->whereRaw('find_in_set(?, genres)', [$genre]);
        $query->limit($showpost);
        
        return view('data.movies_by_genre', [
            'items' => $query->get()
        ]);
    }
    
    public function getPopularMovies(Request $request) {
        $type = $request->get('type');
        $items = $this->getPopular($type);
        return view('data.popular_movies', [
            'items' => $items
        ]);
    }
    
    protected function getPopular($type) {
        $query = Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'year',
        ])
            ->where('status', '=', 1);
        
        if ($type == 'day' || $type == 'month') {
            switch ($type) {
                case 'day': $date = date('Y-m-d');break;
                case 'month': $date = date('Y-m');break;
                default: $date = date('Y-m-d');break;
            }
            
            $query->whereIn('id', function ($builder) use ($date) {
                $builder->select(['movie_id'])
                    ->from('movie_views')
                    ->where('day', 'like', $date . '%')
                    ->orderBy('views', 'desc');
            });
        }
        
        if ($type == 'week') {
            $day = date('w');
            $week_start = date('Y-m-d', strtotime('-'. $day .' days'));
            $week_end = date('Y-m-d', strtotime('+'. (6-$day) .' days'));
            
            $query->whereIn('id', function ($builder) use ($week_start, $week_end) {
                $builder->select(['movie_id'])
                    ->from('movie_views')
                    ->where('day', '>=', $week_start)
                    ->where('day', '<=', $week_end)
                    ->orderBy('views', 'desc');
            });
        }
    
        $query->orderBy('views', 'DESC');
        
        $query->limit(10);
        return $query->get();
    }
}
