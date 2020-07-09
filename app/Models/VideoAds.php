<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VideoAds extends Model
{
    protected $table = 'video_ads';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'title',
        'url',
        'description',
        'video_url',
    ];
}
