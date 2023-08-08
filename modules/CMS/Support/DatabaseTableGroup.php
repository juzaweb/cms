<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Database\Migrations\Migrator;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\TableGroupContract;
use Juzaweb\CMS\Models\TableGroup;
use Juzaweb\CMS\Models\TableGroupData;
use Juzaweb\CMS\Models\TableGroupTable;

class DatabaseTableGroup implements TableGroupContract
{
    protected int $maxRows = 3000000;

    protected int $rangeRows = 500000;

    protected Migrator $migrator;

    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
    }

    public function createTable(string $table, string $key): TableGroupTable
    {
        $group = TableGroup::where('table', '=', $table)->first();

        $db = $this->migrator->resolveConnection(null);

        DB::beginTransaction();
        try {
            $newTable = $table . "_" . Str::lower(Str::random(10));

            foreach ($group->migrations as $migrate) {
                $migration = require base_path($migrate);

                $queries = array_column(
                    $db->pretend(
                        function () use ($migration) {
                            $migration->up();
                        }
                    ),
                    'query'
                );

                foreach ($queries as $query) {
                    $query = str_replace($table, $newTable, $query);
                    DB::statement($query);
                }
            }

            $groupTable = TableGroupTable::create(
                [
                    'table' => $table,
                    'real_table' => $newTable,
                    'table_group_id' => $group->id,
                ]
            );

            TableGroupData::create(
                [
                    'table' => $table,
                    'real_table' => $newTable,
                    'table_key' => $key,
                    'table_group_id' => $group->id,
                    'table_group_table_id' => $groupTable->id
                ]
            );

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $groupTable;
    }

    public function insertMultiple(string $table, array $values): bool
    {
        $keys = array_keys($values);

        $groupData = TableGroupData::with(['tableGroupTable'])
            ->where('table', '=', $table)
            ->whereIn('table_key', $keys)
            ->get(
                [
                    'table_key',
                    'real_table',
                    'table_group_id',
                    'table_group_table_id'
                ]
            );

        $tables = [];
        $keyExists = [];
        foreach ($groupData as $group) {
            $tables[$group->real_table] = [
                'table' => $group->tableGroupTable,
                'values' => $groupData
                    ->where('real_table', '=', $group->real_table)
                    ->pluck('table_key')
                    ->toArray()
            ];
            $keyExists[] = $group->table_key;
        }

        $keys = array_diff($keys, $keyExists);
        if ($keys) {
            $tableGroupTable = $this->findOrCreateTable(
                $table,
                $keys[array_key_first($keys)
                ]
            );

            $tables[$tableGroupTable->real_table] = [
                'values' => $keys,
                'table' => $tableGroupTable,
            ];

            $groupDataInserts = collect($keys)
                ->map(
                    function ($item) use ($table, $tableGroupTable) {
                        return [
                            'table' => $table,
                            'real_table' => $tableGroupTable->real_table,
                            'table_key' => $item,
                            'table_group_id' => $tableGroupTable->table_group_id,
                            'table_group_table_id' => $tableGroupTable->id
                        ];
                    }
                )
                ->toArray();

            DB::table(TableGroupData::getTableName())
                ->insert($groupDataInserts);
        }

        foreach ($tables as $key => $vals) {
            $data = array_only($values, $vals['values']);
            $inserts = [];

            foreach ($data as $items) {
                foreach ($items as $item) {
                    $inserts[] = $item;
                }
            }

            DB::beginTransaction();
            try {
                DB::table($key)->lockForUpdate()->insert($inserts);

                $total = count($inserts);

                ($vals['table'])->lockForUpdate()
                    ->increment('total_rows', $total);

                ($vals['table'])->tableGroup
                    ->lockForUpdate()
                    ->increment('total_rows', $total);

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                throw $e;
            }
        }

        return true;
    }

    public function insert(string $table, string $tableKey, array $values): bool
    {
        return $this->query($table, $tableKey)->insert($values);
    }

    public function query(string $table, string $key): Builder
    {
        return DB::table($this->table($table, $key));
    }

    public function table(string $table, string $key): string
    {
        $data = TableGroupData::where(['table' => $table, 'table_key' => $key])
            ->first(['table_group_table_id']);

        if ($data) {
            $group = TableGroupTable::with(['tableGroup'])
                ->where(['id' => $data->table_group_table_id])
                ->first(['real_table']);

            return $group->real_table;
        }

        $group = $this->findOrCreateTable($table, $key);

        return $group->real_table;
    }

    public function findOrCreateTable(string $table, string $key): TableGroupTable
    {
        $group = $this->findSpaceTable($table);

        if ($group) {
            return $group;
        }

        return $this->createTable($table, $key);
    }

    public function getMaxRows(): int
    {
        return $this->maxRows;
    }

    protected function findSpaceTable(string $table): ?TableGroupTable
    {
        return TableGroupTable::where('table', '=', $table)
            ->where('total_rows', '<', $this->getMaxRows() - $this->rangeRows)
            ->orderBy('total_rows', 'ASC')
            ->first();
    }
}
