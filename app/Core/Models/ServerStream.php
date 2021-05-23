<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\ServerStream
 *
 * @property int $id
 * @property string $key
 * @property string $name
 * @property string $base_url
 * @property int $priority
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream query()
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereBaseUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ServerStream whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class ServerStream extends Model
{
    protected $table = 'server_streams';
    protected $fillable = [
        'key',
        'name',
        'base_url',
        'priority',
        'status',
    ];
    
    public function getLinkStream() {
    
    }
}
