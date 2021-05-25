<?php

namespace Mymo\Core\Models;

use Mymo\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use UseSlug;
    
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
}
