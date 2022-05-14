<?php

namespace Juzaweb\DevTool\Commands\Plugin;

use ErrorException;
use Illuminate\Console\Command;
use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Juzaweb\CMS\Contracts\LocalPluginRepositoryContract;
use Juzaweb\CMS\Support\Config\GenerateConfigReader;
use Juzaweb\CMS\Support\Plugin;
use Juzaweb\CMS\Traits\ModuleCommandTrait;
use RuntimeException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class SeedCommand extends Command
{
    use ModuleCommandTrait;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'plugin:db-seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run database seeder from the specified plugin or from all plugins.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            if ($name = $this->argument('module')) {
                $this->moduleSeed($this->getModuleByName($name));
            } else {
                $modules = $this->getModuleRepository()->getOrdered();
                array_walk($modules, [$this, 'moduleSeed']);
                $this->info('All plugins seeded.');
            }
        } catch (\Error $e) {
            $e = new ErrorException($e->getMessage(), $e->getCode(), 1, $e->getFile(), $e->getLine(), $e);
            $this->reportException($e);
            $this->renderException($this->getOutput(), $e);

            return 1;
        } catch (\Exception $e) {
            $this->reportException($e);
            $this->renderException($this->getOutput(), $e);

            return 1;
        }
    }

    /**
     * @param Plugin $module
     *
     * @return void
     */
    public function moduleSeed(Plugin $module)
    {
        $seeders = [];
        $name = $module->getName();
        $config = $module->get('migration');

        if (is_array($config) && array_key_exists('seeds', $config)) {
            foreach ((array)$config['seeds'] as $class) {
                if (class_exists($class)) {
                    $seeders[] = $class;
                }
            }
        } else {
            $seeds = File::files(plugin_path($name, 'database/seeders'));

            foreach ($seeds as $seed) {
                if ($seed->isFile() && $seed->getExtension() == 'php') {
                    include $seed->getRealPath();
                }
            }

            $class = $this->getSeederName($name);

            if (class_exists($class)) {
                $seeders[] = $class;
            }
        }

        if (count($seeders) > 0) {
            array_walk($seeders, [$this, 'dbSeed']);
            $this->info("Plugin [$name] seeded.");
        }
    }

    /**
     * Get master database seeder name for the specified plugin.
     *
     * @param string $name
     *
     * @return string
     */
    public function getSeederName($name)
    {
        $className = Str::ucfirst(explode('/', $name)[1]);
        $namespace = $this->laravel['plugins']->config('namespace');
        $config = GenerateConfigReader::read('seeder');
        $path = $namespace . '/' . $name . '/' . $config->getPath() . '/' . $className . 'DatabaseSeeder';

        $names = explode('/', $path);
        $class = '';
        foreach ($names as $index => $name) {
            if ($index != 0) {
                $class .= '\\';
            }

            $class .= Str::ucfirst($name);
        }

        return $class;
    }

    /**
     * @param $name
     *
     * @throws RuntimeException
     *
     * @return Plugin
     */
    public function getModuleByName($name)
    {
        $modules = $this->getModuleRepository();
        if ($modules->has($name) === false) {
            throw new RuntimeException("Plugin [$name] does not exists.");
        }

        return $modules->find($name);
    }

    /**
     * @return LocalPluginRepositoryContract
     * @throws RuntimeException
     */
    public function getModuleRepository(): LocalPluginRepositoryContract
    {
        $modules = $this->laravel['plugins'];
        if (! $modules instanceof LocalPluginRepositoryContract) {
            throw new RuntimeException('Plugin repository not found!');
        }

        return $modules;
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Throwable  $e
     * @return void
     */
    protected function reportException(\Exception $e)
    {
        $this->laravel[ExceptionHandler::class]->report($e);
    }

    /**
     * Report the exception to the exception handler.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @param  \Throwable  $e
     * @return void
     */
    protected function renderException($output, \Exception $e)
    {
        $this->laravel[ExceptionHandler::class]->renderForConsole($output, $e);
    }

    /**
     * Get master database seeder name for the specified plugin under a different namespace than Modules.
     *
     * @param string $name
     *
     * @return array $foundModules array containing namespace paths
     */
    public function getSeederNames($name)
    {
        $name = Str::studly($name);

        $seederPath = GenerateConfigReader::read('seeder');
        $seederPath = str_replace('/', '\\', $seederPath->getPath());

        $foundModules = [];
        foreach ($this->laravel['plugins']->config('scan.paths') as $path) {
            $namespace = array_slice(explode('/', $path), -1)[0];
            $foundModules[] = $namespace . '\\' . $name . '\\' . $seederPath . '\\' . $name . 'DatabaseSeeder';
        }

        return $foundModules;
    }

    /**
     * Seed the specified plugin.
     *
     * @param string $className
     */
    protected function dbSeed($className)
    {
        if ($option = $this->option('class')) {
            $params['--class'] = Str::finish(substr($className, 0, strrpos($className, '\\')), '\\') . $option;
        } else {
            $params = ['--class' => $className];
        }

        if ($option = $this->option('database')) {
            $params['--database'] = $option;
        }

        if ($option = $this->option('force')) {
            $params['--force'] = $option;
        }

        $this->call('db:seed', $params);
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['module', InputArgument::OPTIONAL, 'The name of plugin will be used.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['class', null, InputOption::VALUE_OPTIONAL, 'The class name of the root seeder.'],
            ['database', null, InputOption::VALUE_OPTIONAL, 'The database connection to seed.'],
            ['force', null, InputOption::VALUE_NONE, 'Force the operation to run when in production.'],
        ];
    }
}
