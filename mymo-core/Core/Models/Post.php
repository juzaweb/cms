<?php

namespace Mymo\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Mymo\Repository\Contracts\Transformable;
use Mymo\Repository\Traits\TransformableTrait;

/**
 * Class Post.
 *
 * @package namespace Mymo\Core\Models;
 */
class Post extends Model implements Transformable
{
    use TransformableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [];

}
