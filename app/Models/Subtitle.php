<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subtitle extends Model
{
    protected $table = 'subtitles';
    protected $fillable = [
        'label',
        'url',
        'order',
        'status'
    ];
}
