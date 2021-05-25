<?php

namespace Mymo\Core\Models;

use Mymo\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * Mymo\Core\Models\PostCategories
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories query()
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string $description
 * @method static \Illuminate\Database\Eloquent\Builder|\Mymo\Core\Models\PostCategories whereDescription($value)
 */
class PostCategories extends Model
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
