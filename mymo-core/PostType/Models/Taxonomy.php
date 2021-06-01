<?php

namespace Mymo\PostType\Models;

use Illuminate\Database\Eloquent\Model;
use Mymo\Core\Translatable\Translatable;
use Mymo\Repository\Contracts\Transformable;
use Mymo\Repository\Traits\TransformableTrait;

/**
 * Class Taxonomy.
 *
 * @package namespace Mymo\Core\Models;
 */
class Taxonomy extends Model implements Transformable
{
    use TransformableTrait, Translatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];


}
