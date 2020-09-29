<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\DownloadLink
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\DownloadLink whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class DownloadLink extends Model
{
    protected $table = 'download_links';
    protected $fillable = [
        'label',
        'url',
        'order',
        'status'
    ];
}
