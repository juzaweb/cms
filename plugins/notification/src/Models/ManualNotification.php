<?php

namespace Juzaweb\Notification\Models;

use Illuminate\Database\Eloquent\Model;

class ManualNotification extends Model
{
    protected $table = 'manual_notifications';
    protected $fillable = [
        'method',
        'users',
        'data',
        'status',
        'error'
    ];

    public $casts = [
        'data' => 'array',
    ];
}
