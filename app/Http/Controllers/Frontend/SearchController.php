<?php

namespace App\Http\Controllers\Frontend;

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
            'release',
            'created_at',
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
            if ($query->exists()) {
                $query->limit(10);
                return view('themes.mymo.data.search_item', [
                    'keyword' => $q,
                    'items' => $query->get(),
                ]);
            }
            
            return response()->json([
                'status' => 'error',
                'message' => '',
            ]);
        }
        
        return view('frontend.genre.index', [
            'items' => $query->paginate(20),
        ]);
    }
    
    public function getPopularMovies(Request $request) {
        $q = $request->get('q');
        $date = date('Y-m-d');
        switch ($q) {
            case 'day': $date = date('Y-m-d');break;
            case 'month': $date = date('Y-m');break;
            case 'year': $date = date('Y');break;
        }
        
        $rows = $this->getPopular($date);
        return response()->json($rows);
    }
    
    protected function getPopular($date) {
        return Movies::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'release',
        ])
            ->where('status', '=', 1)
            ->whereIn('id', function (Builder $builder) use ($date) {
                $builder->select(['movie_id'])
                    ->from('movie_views')
                    ->where('created_at', 'like', $date . '%');
            })
            ->limit(5)
            ->get()
            ->toArray();
    }
}
