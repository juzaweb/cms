<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailList extends Model
{
    protected $table = 'email_list';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'params',
        'template',
    ];
}
