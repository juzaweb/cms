<?php

namespace App\Models\PaidMembers;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $table = 'packages';
    protected $fillable = [
        'name',
        'days',
        'price',
        'status',
    ];
    
    public function users() {
        return $this->hasMany('App\User', 'package_id', 'id');
    }
}
