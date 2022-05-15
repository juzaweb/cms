<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Commands\Resource;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Juzaweb\CMS\Abstracts\ResourceCommand;
use Symfony\Component\Console\Input\InputArgument;

class JuzawebResouceMakeCommand extends ResourceCommand
{
    /**
     * The name of argument being used.
     *
     * @var string
     */
    protected $argumentName = 'name';

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:make-jwresource';

    public function handle()
    {
        $this->module = $this->laravel['plugins']->find($this->getModuleName());

        $table = $this->argument('name');

        if (! Schema::hasTable($table)) {
            $this->error("Table [{$table}] does not exist. Please create table.");
            exit(1);
        }

        $this->columns = collect(Schema::getColumnListing($table))
            ->filter(function ($item) {
                return ! in_array($item, [
                    'id',
                    'created_at',
                    'updated_at',
                    'created_by',
                    'updated_by',
                ]);
            })->toArray();

        $model = Str::studly($table);
        $singular = Str::singular($model);

        $this->makeModel($table, $singular);

        $this->makeDataTable($singular);

        $this->makeController($table, $singular);

        $this->makeViews($table);

        $routePath = $this->module->getPath() . '/src/routes/admin.php';
        $this->info('Add resource route ' . $routePath);

        $content = "Route::jwResource('{$table}', 'Backend\\{$singular}Controller');";
        file_put_contents(
            $routePath,
            PHP_EOL.$content.PHP_EOL,
            FILE_APPEND | LOCK_EX
        );
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the table.'],
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }
}
