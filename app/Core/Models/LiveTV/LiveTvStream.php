<?php

namespace App\Core\Models\LiveTV;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\LiveTV\LiveTvStream
 *
 * @property int $id
 * @property string $label
 * @property string $from
 * @property string $url
 * @property int $live_tv_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream query()
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereFrom($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereLabel($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereLiveTvId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereUrl($value)
 * @mixin \Eloquent
 * @property int $order
 * @method static \Illuminate\Database\Eloquent\Builder|LiveTvStream whereOrder($value)
 */
class LiveTvStream extends Model
{
    protected $table = 'live_tv_streams';
    protected $fillable = [
        'label',
        'from',
        'url',
        'order'
    ];
}
