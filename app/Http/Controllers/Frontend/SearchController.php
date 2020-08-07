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
            'video_quality',
            'year',
            'genres',
            'countries',
            'tv_series',
            'current_episode',
            'max_episode',
            'created_at',
        ]);
        
        $query->where('status', '=', 1);
        
        if ($q) {
            $query->where(function (Builder $builder) use ($q) {
                $builder->orWhere('name', 'like', '%'. $q .'%');
                $builder->orWhere('other_name', 'like', '%'. $q .'%');
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
}
