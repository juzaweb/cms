<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\TmdbApi;
use App\Models\Countries;
use App\Models\Genres;
use App\Models\Stars;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;

class TmdbController extends Controller
{
    public function addMovie(Request $request) {
        $this->validateRequest([
            'tmdb' => 'required',
        ], $request);
        
        $movie = $this->getMovieById($request->post('tmdb'));
    }
    
    protected function getMovieById($imdb_id) {
        $api = new TmdbApi();
        $api->setAPIKey(get_config('tmdb_api_key'));
        $result = $api->getMovie($imdb_id);
        dd($result);
    }
    
    protected function addOrGetGenre($name) {
        $slug = Str::slug($name);
        $genre = Genres::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Genres();
        $model->name = $name;
        $model->slug = $slug;
        $model->save();
        return $model->id;
    }
    
    protected function addOrGetCountry($name) {
        $slug = Str::slug($name);
        $genre = Countries::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Countries();
        $model->name = $name;
        $model->slug = $slug;
        $model->save();
        return $model->id;
    }
    
    protected function addOrGetStar($name, $type = '') {
        $slug = Str::slug($name);
        $genre = Stars::where('slug', $slug)->first(['id']);
        if ($genre) {
            return $genre->id;
        }
        
        $model = new Stars();
        $model->name = $name;
        $model->slug = $slug;
        $model->type = $type;
        $model->save();
        return $model->id;
    }
}
