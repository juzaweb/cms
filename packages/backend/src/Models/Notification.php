<?php

namespace Juzaweb\Backend\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';

    protected $fillable = [
        'id',
        'type',
        'data',
        'read_at',
        'notifiable_type',
        'notifiable_id',
    ];

    public $casts = [
        'data' => 'array',
    ];
}
