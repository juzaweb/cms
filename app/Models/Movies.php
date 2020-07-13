<?php

namespace App\Models;

use App\Traits\UseChangeBy;
use App\Traits\UseMetaSeo;
use App\Traits\UseSlug;
use App\Traits\UseThumbnail;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Movies extends Model
{
    use UseThumbnail, UseSlug, UseMetaSeo, UseChangeBy;
    
    protected $table = 'movies';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'other_name',
        'description',
        'thumbnail',
        'poster',
        'rating',
        'release',
        'runtime',
        'video_quality',
        'trailer_link',
        'current_episode',
        'max_episode',
        'status',
    ];
    
    public function getViews() {
        if ($this->views < 1000) {
            return $this->views;
        }
        
        return round($this->views / 1000, 1) . 'K';
    }
}
