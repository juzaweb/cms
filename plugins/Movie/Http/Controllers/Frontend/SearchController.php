<?php

namespace Plugins\Movie\Http\Controllers\Frontend;

use Mymo\Core\Http\Controllers\FrontendController;
use Mymo\PostType\Models\Taxonomy;
use Plugins\Movie\Models\Movie\Movie;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class SearchController extends FrontendController
{
    public function search(Request $request)
    {
        $q = $request->get('q');
        $data = $request->get('data');
        $genre = $request->get('genre');
        $country = $request->get('country');
        $year = $request->get('year');
        $sort = $request->get('sort');
        $formality = $request->get('formality');
        $status = $request->get('status');
        
        $query = Movie::select([
            'id',
            'name',
            'other_name',
            'short_description',
            'thumbnail',
            'slug',
            'views',
            'video_quality',
            'year',
            'tv_series',
            'current_episode',
            'max_episode',
            'created_at',
        ]);
        
        $query->wherePublish();
        
        if ($q) {
            $query->where(function (Builder $builder) use ($q) {
                $builder->orWhere('name', 'like', '%'. $q .'%');
                $builder->orWhere('other_name', 'like', '%'. $q .'%');
            });
        }
        
        if ($genre) {
            $query->whereTaxonomy($genre);
        }
    
        if ($country) {
            $query->whereTaxonomy($country);
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
            'name' => trans('mymo::app.result_for_keyword') . ' '. $q,
        ];
        
        return view('genre.index', [
            'title' => trans('mymo::app.result_for_keyword') . ' '. $q,
            'description' => trans('mymo::app.result_for_keyword') . ' '. $q,
            'keywords' => trans('mymo::app.result_for_keyword') . ' '. $q,
            'info' => $info,
            'items' => $query->paginate(20),
        ]);
    }
    
    public function filterForm()
    {
        $genres = Taxonomy::where('taxonomy', '=', 'genres')
            ->get(['id', 'name']);
        $countries = Taxonomy::where('taxonomy', '=', 'countries')
            ->get(['id', 'name']);
        $years = Movie::wherePublish()
            ->groupBy('year')
            ->get(['year']);
        
        return view('data.filter_form', [
            'genres' => $genres,
            'countries' => $countries,
            'years' => $years,
        ]);
    }
}
