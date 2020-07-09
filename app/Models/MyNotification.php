<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyNotification extends Model
{
    protected $table = 'my_notification';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'subject',
        'content',
        'type',
    ];
}
