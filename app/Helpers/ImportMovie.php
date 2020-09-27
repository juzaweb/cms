<?php

namespace App\Helpers;

use App\Models\Countries;
use App\Models\Files;
use App\Models\Genres;
use App\Models\Movies;
use App\Models\Stars;
use Illuminate\Support\Str;

class ImportMovie
{
    public $data;
    public $errors;
    
    public function __construct(array $data) {
        $fill_data = [
            'name',
            'other_name',
            'description',
            'short_description',
            'type_id',
            'poster',
            'rating',
            'release',
            'runtime',
            'video_quality',
            'trailer_link',
            'current_episode',
            'max_episode',
            'year',
            'thumbnail',
            'poster',
            'tv_series',
        ];
        
        $array_data = [
            'genres',
            'countries',
            'actors',
            'writers',
            'directors',
        ];
        
        foreach ($fill_data as $item) {
            if (!isset($data[$item])) {
                $data[$item] = null;
            }
            else {
                $data[$item] = trim($data[$item]);
            }
        }
    
        foreach ($array_data as $item) {
            if (!isset($data[$item])) {
                $data[$item] = [];
            }
        }
        
        $this->data = $data;
    }
    
    public function save() {
        if (!$this->validate()) {
            return false;
        }
        
        $model = new Movies();
        $model->fill($this->data);
        $model->thumbnail = $this->downloadImage($this->data['thumbnail'], $this->data['name']);
        $model->poster = $this->downloadImage($this->data['poster'], $this->data['name']);
        $model->genres = $this->getGenreIds($this->data['genres']);
        $model->countries = $this->getCounrtyIds($this->data['countries']);
    
        $model->actors = $this->getStarIds($this->data['actors'], 'actor');
        $model->writers = $this->getStarIds($this->data['writers'], 'writer');
        $model->directors = $this->getStarIds($this->data['directors'], 'director');
        $model->tv_series = $this->data['tv_series'] ? 1 : 0;
        $model->status = 2;
    
        if ($model->release && empty($model->year)) {
            $model->year = explode('-', $model->release)[0];
        }
        
        if (empty($model->video_quality)) {
            $model->video_quality = 'HD';
        }
        
        if ($model->description && empty($model->short_description)) {
            $model->short_description = sub_words(strip_tags($model->description), 15);
        }
    
        return $model->save();
    }
    
    public function validate() {
        if (empty($this->data['name'])) {
            $this->errors[] = 'Name is required';
        }
    
        if (empty($this->data['description'])) {
            $this->errors[] = 'Description is required';
        }
    
        if (empty($this->data['thumbnail'])) {
            $this->errors[] = 'Thumbnail is required';
        }
        
        if (empty($this->data['genres'])) {
            $this->errors[] = 'Genres is required';
        }
        
        if ($this->data['tv_series'] === null) {
            $this->errors[] = 'TV series is required';
        }
        
        if (count($this->errors) > 0) {
            return false;
        }
        
        return true;
    }
    
    protected function downloadImage($thumbnail, $name) {
        $data = [];
        $data['name'] = basename($thumbnail);
        $slip = explode('.', $data['name']);
        $data['extension'] = $slip[count($slip) - 1];
        $file_name = str_replace('.' . $data['extension'], '', $data['name']);
        $new_file = Str::slug($file_name) . '-' . Str::random(10) . '-'. time() .'.' . $data['extension'];
        
        $new_dir = \Storage::disk('public')->path(date('Y/m/d'));
        if (!is_dir($new_dir)) {
            \File::makeDirectory($new_dir, 0775, true);
        }
        
        $get_file = file_put_contents($new_dir . '/' . $new_file, file_get_contents($thumbnail));
        if ($get_file) {
            $data['path'] = date('Y/m/d') .'/'. $new_file;
            $model = new Files();
            $model->fill($data);
            $model->type = 1;
            $model->mime_type = \Storage::disk('public')
                ->mimeType($data['path']);
            $model->user_id = \Auth::id();
            $model->save();
            
            return $data['path'];
        }
        
        return null;
    }
    
    protected function getGenreIds($genres) {
        if (is_string($genres)) {
            return implode(',', $genres);
        }
        
        $result = [];
        foreach ($genres as $genre) {
            if ($genre['name']) {
                $result[] = $this->addOrGetGenre($genre['name']);
            }
        }
        return $result;
    }
    
    protected function getCounrtyIds($countries) {
        if (empty($countries)) {
            return null;
        }
        
        if (is_string($countries)) {
            return implode(',', $countries);
        }
        
        $result = [];
        foreach ($countries as $country) {
            if ($country['name']) {
                $result[] = $this->addOrGetCountry($country['name']);
            }
        }
        return $result;
    }
    
    protected function getStarIds($stars, $type = 'actor') {
        if (is_string($stars)) {
            return implode(',', $stars);
        }
        
        $result = [];
        foreach ($stars as $star) {
            if ($star['name']) {
                $result[] = $this->addOrGetStar($star['name'], $type);
            }
        }
        return $result;
    }
    
    protected function addOrGetGenre($name) {
        $name = trim($name);
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
        $name = trim($name);
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
    
    protected function addOrGetStar($name, $type = 'actor') {
        $name = trim($name);
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