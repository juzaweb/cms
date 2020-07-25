<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Countries;
use App\Models\Genres;
use App\Models\Movies;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request) {
        $q = $request->get('q');
        $data = $request->get('data');
        $genre = $request->get('genre');
        $country = $request->get('country');
        $year = $request->get('year');
    
        $query = Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'year',
            'created_at',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
        ]);
        
        $query->where('status', '=', 1);
        
        if ($q) {
            $query->where(function (Builder $builder) use ($q) {
                $q = full_text_wildcards($q);
                $builder->orWhereRaw('MATCH (name) AGAINST (? IN BOOLEAN MODE)', [$q]);
                $builder->orWhereRaw('MATCH (other_name) AGAINST (? IN BOOLEAN MODE)', [$q]);
            });
        }
        
        if ($genre) {
            $query->whereRaw('find_in_set(?, genres)', [$genre]);
        }
    
        if ($country) {
            $query->whereRaw('find_in_set(?, countries)', [$country]);
        }
    
        if ($year) {
            $query->where('release', 'like', $year . '%');
        }
        
        if ($data == 'html') {
            $query->limit(10);
            return view('themes.mymo.data.search_item', [
                'keyword' => $q,
                'items' => $query->get(),
            ]);
        }
        
        return view('themes.mymo.genre.index', [
            'items' => $query->paginate(20),
        ]);
    }
    
    public function filterForm() {
        $genres = Genres::where('status', '=', 1)
            ->get(['id', 'name']);
        $countries = Countries::where('status', '=', 1)
            ->get(['id', 'name']);
        $years = Movies::where('status', '=', 1)
            ->groupBy('year')
            ->get(['year']);
        
        return view('themes.mymo.data.filter_form', [
            'genres' => $genres,
            'countries' => $countries,
            'years' => $years,
        ]);
    }
    
    public function getPopularMovies(Request $request) {
        $type = $request->get('type');
        $items = $this->getPopular($type);
        return view('themes.mymo.data.popular_movies', [
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
                    ->where('created_at', 'like', $date . '%')
                    ->orderBy('views', 'desc');
            });
        }
        
        if ($type == 'week') {
            $day = date('w');
            $week_start = date('Y-m-d 00:00:00', strtotime('-'. $day .' days'));
            $week_end = date('Y-m-d 23:59:59', strtotime('+'. (6-$day) .' days'));
            
            $query->whereIn('id', function ($builder) use ($week_start, $week_end) {
                $builder->select(['movie_id'])
                    ->from('movie_views')
                    ->where('created_at', '>=', $week_start)
                    ->where('created_at', '<=', $week_end)
                    ->orderBy('views', 'desc');
            });
        }
    
        if ($type == 'all') {
            $query->orderBy('views', 'DESC');
        }
        
        $query->limit(10);
        return $query->get();
    }
}
