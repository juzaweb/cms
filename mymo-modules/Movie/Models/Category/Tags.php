<?php

namespace Modules\Movie\Models\Category;

use App\Core\Traits\UseSlug;
use Illuminate\Database\Eloquent\Model;

class Tags extends Model
{
    use UseSlug;
    
    protected $table = 'tags';
    protected $primaryKey = 'id';
    protected $fillable = ['name'];
}
