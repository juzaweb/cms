<?php

namespace Plugins\Movie\Helpers;

use Plugins\Movie\Models\Category\Countries;
use Plugins\Movie\Models\Files;
use Plugins\Movie\Models\Category\Genres;
use Plugins\Movie\Models\Movie\Movies;
use Plugins\Movie\Models\Category\Stars;
use Plugins\Movie\Models\Category\Tags;
use Illuminate\Support\Str;

class ImportMovie
{
    public $data;
    public $errors = [];
    
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
            'tags'
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
    
    /**
     * Save import movie.
     *
     * @return Movies|false
     */
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
        $model->tags = $this->getTagsIds($this->data['tags']);
        $model->tv_series = $this->data['tv_series'] ? 1 : 0;
        $model->status = 1;
    
        $model->created_by = \Auth::check() ? \Auth::id() : 1;
        $model->updated_by = \Auth::check() ? \Auth::id() : 1;
    
        if ($model->release && empty($model->year)) {
            $model->year = explode('-', $model->release)[0];
        }
        
        if (empty($model->video_quality)) {
            $model->video_quality = 'HD';
        }
        
        if ($model->description && empty($model->short_description)) {
            $model->short_description = sub_words(strip_tags($model->description), 15);
        }
        
        $model->save();
        return $model;
    }

    public function validate() {
        if (empty($this->data['name'])) {
            $this->errors[] = 'Name is required.';
        }
    
        if (empty($this->data['description'])) {
            $this->errors[] = 'Description is required.';
        }
    
        if (empty($this->data['thumbnail'])) {
            $this->errors[] = 'Thumbnail is required.';
        }
        
        if (empty($this->data['genres'])) {
            $this->errors[] = 'Genres is required.';
        }
        
        if ($this->data['tv_series'] === null) {
            $this->errors[] = 'TV Series is required.';
        }
        
        if (Movies::where('other_name', '=', $this->data['other_name'])
            ->where('year', '=', $this->data['year'])
            ->whereNotNull('other_name')
            ->whereNotNull('year')
            ->exists()) {
            $this->errors[] = 'Movie is exists.';
        }
        
        if (count($this->errors) > 0) {
            return false;
        }
        
        return true;
    }
    
    protected function downloadImage($image, $name) {
        if (empty($image)) {
            return null;
        }
        
        $data = [];
        $data['name'] = basename($image);
        $slip = explode('.', $data['name']);
        $data['extension'] = $slip[count($slip) - 1];
        $new_file = Str::slug($name) . '-' . Str::random(10) . '-'. time() .'.' . $data['extension'];
        
        $new_dir = \Storage::disk('public')->path(date('Y/m/d'));
        if (!is_dir($new_dir)) {
            \File::makeDirectory($new_dir, 0775, true);
        }
        
        $get_file = file_put_contents($new_dir . '/' . $new_file, file_get_contents($image));
        if ($get_file) {
            $data['path'] = date('Y/m/d') .'/'. $new_file;
            $model = new Files();
            $model->fill($data);
            $model->type = 1;
            $model->mime_type = \Storage::disk('public')
                ->mimeType($data['path']);
            $model->user_id = \Auth::check() ? \Auth::id() : 1;
            $model->save();
            
            return $data['path'];
        }
        
        return null;
    }
    
    protected function getGenreIds($genres) {
        if (is_string($genres)) {
            return $genres;
        }
        
        $result = [];
        foreach ($genres as $genre) {
            if ($genre['name']) {
                $result[] = $this->addOrGetGenre($genre['name']);
            }
        }
        return implode(',', $result);
    }
    
    protected function getCounrtyIds($countries) {
        if (empty($countries)) {
            return null;
        }
        
        if (is_string($countries)) {
            return $countries;
        }
        
        $result = [];
        foreach ($countries as $country) {
            if ($country['name']) {
                $result[] = $this->addOrGetCountry($country['name']);
            }
        }
        return implode(',', $result);
    }
    
    protected function getStarIds($stars, $type = 'actor') {
        if (is_string($stars)) {
            return $stars;
        }
        
        $result = [];
        foreach ($stars as $star) {
            if ($star['name']) {
                $result[] = $this->addOrGetStar($star['name'], $type);
            }
        }
        return implode(',', $result);
    }
    
    protected function getTagsIds($tags) {
        if (is_string($tags)) {
            return $tags;
        }
        
        $result = [];
        foreach ($tags as $tag) {
            if ($tag['name']) {
                $result[] = $this->addOrGetTag($tag['name']);
            }
        }
        
        return implode(',', $result);
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
    
    protected function addOrGetTag($name) {
        $name = trim($name);
        $slug = Str::slug($name);
        $tag = Tags::where('slug', $slug)->first(['id']);
        if ($tag) {
            return $tag->id;
        }
        
        $model = new Tags();
        $model->name = $name;
        $model->slug = $slug;
        $model->save();
        return $model->id;
    }
}