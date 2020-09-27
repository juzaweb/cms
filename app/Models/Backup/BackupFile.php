<?php

namespace App\Models\Backup;

use Illuminate\Database\Eloquent\Model;

class BackupFile extends Model
{
    protected $table = 'backup_files';
    protected $fillable = [
        'source',
        'url',
        'status',
    ];
}
