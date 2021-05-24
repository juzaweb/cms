<?php

namespace App\Core\Http\Controllers\Frontend;

use App\Core\Models\Category\Countries;
use App\Core\Models\Category\Genres;
use App\Core\Models\Movie\Movies;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use App\Core\Http\Controllers\Controller;

class SearchController extends Controller
{
    public function search(Request $request) {
        $q = $request->get('q');
        $data = $request->get('data');
        $genre = $request->get('genre');
        $country = $request->get('country');
        $year = $request->get('year');
        $sort = $request->get('sort');
        $formality = $request->get('formality');
        $status = $request->get('status');
        
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
        
        if ($formality) {
            $query->where('tv_series', 'like', $formality - 1);
        }
        
        if ($status) {
            if ($status == 'completed') {
                $query->where(function (Builder $builder) {
                    $builder->orWhereNull('max_episode');
                    $builder->orWhereColumn('current_episode', '=', 'max_episode');
                });
            }
            
            if ($status == 'ongoing') {
                $query->where(function (Builder $builder) {
                    $builder->orWhereNull('max_episode');
                    $builder->orWhereColumn('current_episode', '<', 'max_episode');
                });
            }
        }
        
        if ($sort) {
            switch ($sort) {
                case 'top_views': $orderby = 'views DESC';break;
                case 'new_update': $orderby = 'updated_at DESC';break;
                default: $orderby = 'id DESC';break;
            }
            
            $query->orderByRaw($orderby);
        }
        
        if ($data == 'html') {
            $query->limit(10);
            return view('data.search_item', [
                'keyword' => $q,
                'items' => $query->get(),
            ]);
        }
        
        $info = (object) [
            'name' => trans('app.result_for_keyword') . ' '. $q,
        ];
        
        return view('genre.index', [
            'title' => trans('app.result_for_keyword') . ' '. $q,
            'description' => trans('app.result_for_keyword') . ' '. $q,
            'keywords' => trans('app.result_for_keyword') . ' '. $q,
            'info' => $info,
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
        
        return view('data.filter_form', [
            'genres' => $genres,
            'countries' => $countries,
            'years' => $years,
        ]);
    }
}
