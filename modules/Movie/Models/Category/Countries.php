<?php

namespace App\Core\Models\Category;

use App\Core\Traits\UseMetaSeo;
use App\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Category\Countries
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $description
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereDescription($value)
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $keywords
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Category\Countries whereMetaTitle($value)
 */
class Countries extends Model
{
    use UseSlug, UseMetaSeo;
    
    protected $table = 'countries';
    protected $primaryKey = 'id';
    protected $fillable = ['name', 'description', 'status'];
}
