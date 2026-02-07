<?php

namespace Juzaweb\Modules\AdsManagement\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Juzaweb\Modules\Core\Models\Model;

class VideoAds extends Model
{
    use HasUuids;

    protected $table = 'video_ads';

    protected $fillable = [
        'name',
        'title',
        'url',
        'video',
        'position',
        'offset',
        'options',
        'active',
        'views',
        'click',
    ];

    public $casts = [
        'options' => 'array',
        'active' => 'boolean',
        'views' => 'integer',
        'click' => 'integer',
        'offset' => 'integer',
    ];

    public static function getFieldName(): string
    {
        return 'name';
    }
}
