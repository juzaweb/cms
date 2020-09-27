<?php

namespace App\Http\Controllers\Backend;

use App\Models\Countries;
use App\Models\Genres;
use App\Models\Stars;
use App\Models\Tags;
use App\Models\Types;
use App\Models\VideoQualities;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Movie\Movies;
use Illuminate\Support\Str;

class MoviesController extends Controller
{
    public function index() {
        return view('backend.movies.index');
    }
    
    public function getData(Request $request) {
        $search = $request->get('search');
        $status = $request->get('status');
        $genre = $request->get('genre');
        $country = $request->get('country');
        
        $sort = $request->get('sort', 'id');
        $order = $request->get('order', 'desc');
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 20);
        
        $query = Movies::query();
        $query->where('tv_series', '=', 0);
        
        if ($search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->orWhere('name', 'like', '%'. $search .'%');
                $subquery->orWhere('description', 'like', '%'. $search .'%');
            });
        }
    
        if ($genre) {
            $query->whereRaw('find_in_set(?, genres)', [$genre]);
        }
    
        if ($country) {
            $query->whereRaw('find_in_set(?, countries)', [$country]);
        }
        
        if (!is_null($status)) {
            $query->where('status', '=', $status);
        }
        
        $count = $query->count();
        $query->orderBy($sort, $order);
        $query->offset($offset);
        $query->limit($limit);
        $rows = $query->get();
        
        foreach ($rows as $row) {
            $row->thumb_url = $row->getThumbnail();
            $row->created = $row->created_at->format('H:i Y-m-d');
            $row->description = Str::words(strip_tags($row->description), 15);
            $row->edit_url = route('admin.movies.edit', [$row->id]);
            $row->preview_url = route('watch', [$row->slug]);
            $row->upload_url = route('admin.movies.servers', [$row->id]);
        }
        
        return response()->json([
            'total' => $count,
            'rows' => $rows
        ]);
    }
    
    public function form($id = null) {
        $model = Movies::firstOrNew(['id' => $id]);
        $qualities = VideoQualities::get();
        $tags = Tags::whereIn('id', explode(',', $model->tags))->get(['id', 'name']);
        $genres = Genres::whereIn('id', explode(',', $model->genres))->get(['id', 'name']);
        $type = Types::where('id', '=', $model->type_id)->first(['id', 'name']);
        $countries = Countries::whereIn('id', explode(',', $model->countries))->get(['id', 'name']);
        $directors = Stars::whereIn('id', explode(',', $model->directors))->get(['id', 'name']);
        $writers = Stars::whereIn('id', explode(',', $model->writers))->get(['id', 'name']);
        $actors = Stars::whereIn('id', explode(',', $model->actors))->get(['id', 'name']);
        
        return view('backend.movies.form', [
            'model' => $model,
            'title' => $model->name ?: trans('app.add_new'),
            'qualities' => $qualities,
            'tags' => $tags,
            'genres' => $genres,
            'type' => $type,
            'countries' => $countries,
            'directors' => $directors,
            'writers' => $writers,
            'actors' => $actors,
        ]);
    }
    
    public function save(Request $request) {
        $this->validateRequest([
            'name' => 'required|string|max:250',
            'description' => 'nullable',
            'status' => 'required|in:0,1',
            'thumbnail' => 'nullable|string|max:250',
            'genres' => 'required|array',
            'poster' => 'nullable|string|max:250',
            'rating' => 'nullable|string|max:25',
            'release' => 'nullable|date_format:Y-m-d',
            'runtime' => 'nullable|string|max:100',
            'video_quality' => 'nullable|string|max:100',
            'trailer_link' => 'nullable|string|max:100',
        ], $request, [
            'name' => trans('app.name'),
            'description' => trans('app.description'),
            'status' => trans('app.status'),
            'thumbnail' => trans('app.thumbnail'),
            'genres' => trans('app.genres'),
            'poster' => trans('app.poster'),
            'rating' => trans('app.rating'),
            'release' => trans('app.release'),
            'runtime' => trans('app.runtime'),
            'video_quality' => trans('app.video_quality'),
            'trailer_link' => trans('app.trailer'),
        ]);
    
        $genres = $request->post('genres', []);
        $countries = $request->post('countries', []);
        $actors = $request->post('actors', []);
        $directors = $request->post('directors', []);
        $writers = $request->post('writers', []);
        $tags = $request->post('tags', []);
        
        $model = Movies::firstOrNew(['id' => $request->post('id')]);
        $model->fill($request->all());
        $model->setAttribute('short_description', sub_words(strip_tags($model->description), 15));
        $model->setAttribute('genres', implode(',', $genres));
        $model->setAttribute('countries', implode(',', $countries));
        $model->setAttribute('actors', implode(',', $actors));
        $model->setAttribute('directors', implode(',', $directors));
        $model->setAttribute('writers', implode(',', $writers));
        $model->setAttribute('tags', implode(',', $tags));
        
        if ($model->release) {
            $model->year = explode('-', $model->release)[0];
        }
        
        $model->save();
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.saved_successfully'),
            'redirect' => route('admin.movies'),
        ]);
    }
    
    public function remove(Request $request) {
        $this->validateRequest([
            'ids' => 'required',
        ], $request, [
            'ids' => trans('app.movies')
        ]);
        
        Movies::destroy($request->post('ids'));
        
        return response()->json([
            'status' => 'success',
            'message' => trans('app.deleted_successfully'),
        ]);
    }
}
