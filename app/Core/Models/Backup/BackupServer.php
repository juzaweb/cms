<?php

namespace App\Core\Models\Backup;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Core\Models\Backup\BackupServer
 *
 * @property int $id
 * @property string $name
 * @property string $data
 * @property string $server
 * @property int $order
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereData($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereServer($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Core\Models\Backup\BackupServer whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class BackupServer extends Model
{
    protected $table = 'backup_servers';
    protected $fillable = [
        'name',
        'server',
        'order',
        'status'
    ];
}
