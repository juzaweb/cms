<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TableGroupData extends Model
{
    protected $table = 'table_group_datas';

    protected $fillable = [
        'table',
        'real_table',
        'table_key',
        'table_group_id',
        'table_group_table_id'
    ];

    public $timestamps = false;

    public function tableGroupTable(): BelongsTo
    {
        return $this->belongsTo(TableGroupTable::class, 'table_group_table_id', 'id');
    }
}
