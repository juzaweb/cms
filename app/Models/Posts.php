<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Posts
 *
 * @property int $id
 * @property string $title
 * @property string $slug
 * @property string|null $content
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Posts whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class Posts extends Model
{
    //
}
