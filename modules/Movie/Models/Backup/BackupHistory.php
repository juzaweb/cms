<?php

namespace App\Core\Models\Backup;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Backup\BackupHistory
 *
 * @property int $id
 * @property int $video_file_id
 * @property int $backup_server_id
 * @property string|null $error
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereBackupServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereError($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupHistory whereVideoFileId($value)
 * @mixin \Eloquent
 */
class BackupHistory extends Model
{
    protected $table = 'backup_histories';
    protected $fillable = [
        'file_id',
        'type',
    ];
    
}
