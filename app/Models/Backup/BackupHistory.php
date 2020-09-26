<?php

namespace App\Models\Backup;

use Illuminate\Database\Eloquent\Model;

class BackupHistory extends Model
{
    protected $table = 'backup_histories';
    protected $fillable = [
        'file_id',
        'type',
    ];
    
}
