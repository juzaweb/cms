<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Support;

use Illuminate\Database\DatabaseManager;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Traits\Macroable;
use Juzaweb\CMS\Contracts\JWQueryContract;
use Juzaweb\CMS\Traits\Queries\PostQuery;
use Illuminate\Support\Collection;

class JWQuery implements JWQueryContract
{
    use Macroable, PostQuery;

    protected DatabaseManager $db;

    public function __construct(DatabaseManager $db)
    {
        $this->db = $db;
    }

    public function queryRows(string $table, array $args = []): Collection|null
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        $builder = $this->queryBuilder($table, $args);

        return $builder->get();
    }

    public function queryRow(string $table, array $args = []): object|null
    {
        if (!Schema::hasTable($table)) {
            return null;
        }

        $builder = $this->queryBuilder($table, $args);

        return $builder->first();
    }

    public function count(string $table, array $args = []): int
    {
        if (!Schema::hasTable($table)) {
            return 0;
        }

        $builder = $this->queryBuilder($table, $args);

        return $builder->count();
    }

    protected function queryBuilder(string $table, array $args = []): Builder
    {
        $query = $this->db->table($table);

        if ($wheres = Arr::get($args, 'where')) {
            $this->queryWheresBuilder($query, $wheres);
        }

        return $query;
    }

    protected function queryWheresBuilder($query, array $wheres)
    {
        foreach ($wheres as $column => $value) {
            if (is_array($value)) {
                $query->where($value);
            }

            $condition = '=';

            $query->where($column, $condition, $value);
        }
    }
}
