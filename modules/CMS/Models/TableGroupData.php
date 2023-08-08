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
 * Juzaweb\CMS\Models\TableGroupData
 *
 * @property-read \Juzaweb\CMS\Models\TableGroupTable|null $tableGroupTable
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData query()
 * @mixin \Eloquent
 * @property int $id
 * @property int $table_group_id
 * @property int $table_group_table_id
 * @property string $table
 * @property string $real_table
 * @property string $table_key
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereRealTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereTable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereTableGroupId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereTableGroupTableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TableGroupData whereTableKey($value)
 */
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
