<?php

namespace Juzaweb\Backend\Models;

use Juzaweb\Models\Model;
use Juzaweb\Traits\ResourceModel;

class EmailTemplate extends Model
{
    use ResourceModel;

    protected $fieldName = 'subject';
    protected $table = 'email_templates';
    protected $fillable = [
        'code',
        'subject',
        'body',
        'params',
        'email_hook',
    ];

    protected $casts = [
        'params' => 'array',
    ];
}
