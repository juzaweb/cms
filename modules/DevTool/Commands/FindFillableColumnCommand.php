<?php

namespace Juzaweb\DevTool\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;

class FindFillableColumnCommand extends Command
{
    protected $signature = 'table:fillable {table}';

    protected array $excludeColumns = ['id', 'created_at', 'updated_at'];

    public function handle(): void
    {
        $table = $this->argument('table');

        $columns = Schema::getColumnListing($table);

        foreach ($columns as $column) {
            if (in_array($column, $this->excludeColumns)) {
                continue;
            }

            echo "'" . trim($column) . "',\n";
        }
    }
}
