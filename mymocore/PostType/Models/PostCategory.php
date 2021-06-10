<?php

namespace Mymo\PostType\Models;

use Mymo\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\PostType\Models\PostCategory
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\PostType\Models\PostCategory whereDescription($value)
 */
class PostCategory extends Model
{
    use UseSlug;
    
    protected $table = 'post_categories';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'description',
        'status'
    ];
}
