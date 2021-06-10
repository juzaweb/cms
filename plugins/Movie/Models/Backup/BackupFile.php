<?php

namespace Plugins\Movie\Models\Backup;

use Illuminate\Database\Eloquent\Model;

/**
 * Plugins\Movie\Models\Backup\BackupFile
 *
 * @property int $id
 * @property int $video_file_id
 * @property int $backup_server_id
 * @property string $source
 * @property string $url
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile query()
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereBackupServerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereSource($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereUrl($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BackupFile whereVideoFileId($value)
 * @mixin \Eloquent
 */
class BackupFile extends Model
{
    protected $table = 'backup_files';
    protected $fillable = [
        'source',
        'url',
        'status',
    ];
}
