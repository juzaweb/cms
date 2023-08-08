<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
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
 * @property int $id
 * @property string $table
 * @property string $real_table
 * @property int $table_group_id
 * @property int $total_rows
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable whereRealTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable whereTableGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupTable whereTotalRows($value)
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
