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

class TableGroup extends Model
{
    protected $table = 'table_groups';

    protected $fillable = [
        'table',
        'total_rows',
        'migrations'
    ];

    public $timestamps = false;

    public $casts = [
        'migrations' => 'array'
    ];
}
