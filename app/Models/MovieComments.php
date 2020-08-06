<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MovieComments extends Model
{
    protected $table = 'movie_comments';
    protected $primaryKey = 'id';
    protected $fillable = [
        'content',
        'user_id'
    ];
    
    public function user() {
        return $this->hasOne('App\User', 'id', 'user_id');
    }
    
    public function scopePubliced($query) {
        return $query->where('status', '=', 1)
            ->where('approved', '=', 1);
    }
}
