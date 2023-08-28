<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Commands\Resource;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Juzaweb\CMS\Abstracts\Action;
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

        $this->addLanguageTranslate();

        $routePath = $this->module->getPath().'/src/routes/admin.php';

        $this->info('Add resource route '.$routePath);

        $tableName = $this->getTableNameNonePrefix($table);
        $content = "Route::jwResource('{$tableName}', {$model}Controller::class);";

        //File::append($routePath, PHP_EOL . $content . PHP_EOL);

        $this->info("Generated CRUD for {$table} successfully.");

        $info = "Add to your route:\n\n";
        $info .= "use {$this->module->getNamespace()}Http\Controllers\Backend\\{$model}Controller;\n";
        $info .= $content . "\n\n";

        $info .= "And add to hook ". Action::BACKEND_INIT . " in your action:\n\n";
        $info .= "\$this->hookAction->registerAdminPage(
            '{$tableName}',
            [
                'title' => '". Str::ucfirst($tableName) ."',
            ]
        );";

        $this->comment($info);
    }

    protected function getTableColumns(string $table): array
    {
        return collect(Schema::getColumnListing($table))
            ->filter(
                fn ($item) => !in_array(
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
        $model = $this->getTableNameNonePrefix($table);

        return Str::studly(Str::singular($model));
    }

    protected function getTableNameNonePrefix(string $table): string
    {
        $domain = $this->module->getDomainName();

        return Str::replace("{$domain}_", '', $table);
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
