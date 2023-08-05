<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Commands\Resource;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Juzaweb\DevTool\Abstracts\CRUD\ResourceCommand;
use Symfony\Component\Console\Input\InputArgument;

class CRUDMakeCommand extends ResourceCommand
{
    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected string $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-crud';

    public function handle(): void
    {
        $this->module = $this->laravel['plugins']->find($this->getModuleName());

        $table = $this->argument('name');

        if (!Schema::hasTable($table)) {
            $this->error("Table [{$table}] does not exist. Please create table.");
            exit(1);
        }

        $this->columns = $this->getTableColumns($table);

        $model = $this->getModelNameByTable($table);

        $this->makeModel($table, $model);

        $this->makeRepository($model);

        $this->makeDataTable($model);

        $this->makeController($table, $model);

        $this->makeViews(Str::lower($model));

        $routePath = $this->module->getPath().'/src/routes/admin.php';

        $this->info('Add resource route '.$routePath);

        $content = "Route::jwResource('{$table}', 'Backend\\{$model}Controller');";

        //file_put_contents($routePath, PHP_EOL . $content . PHP_EOL, FILE_APPEND | LOCK_EX);

        $this->info("Add to your route: {$content}");
    }

    protected function getTableColumns(string $table): array
    {
        return collect(Schema::getColumnListing($table))
            ->filter(
                fn($item) => !in_array(
                    $item,
                    [
                        'id',
                        'created_at',
                        'updated_at',
                        'created_by',
                        'updated_by',
                    ]
                )
            )->toArray();
    }

    protected function getModelNameByTable(string $table): string
    {
        $domain = $this->module->getDomainName();

        $model = Str::studly(Str::replace("{$domain}_", '', $table));

        return Str::singular($model);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the table.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }
}
