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

/**
 * Juzaweb\CMS\Models\TableGroupTable
 *
 * @property-read \Juzaweb\CMS\Models\TableGroup|null $tableGroup
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable query()
 * @mixin \Eloquent
 */
class TableGroupTable extends Model
{
    protected $table = 'table_group_tables';

    protected $fillable = [
        'table',
        'real_table',
        'total_rows',
        'table_group_id',
    ];

    public $timestamps = false;

    public function tableGroup(): BelongsTo
    {
        return $this->belongsTo(TableGroup::class, 'table_group_id', 'id');
    }
}
