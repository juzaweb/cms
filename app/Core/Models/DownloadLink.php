<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\DownloadLink
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\DownloadLink whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $label
 * @property string $url
 * @property int $order
 * @property int $status
 * @property int $movie_id
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadLink whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadLink whereMovieId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadLink whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadLink whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|DownloadLink whereUrl($value)
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
    
    public function movie() {
        return $this->hasOne('App\Core\Models\Movie\Movies', 'id', 'movie_id');
    }
}
