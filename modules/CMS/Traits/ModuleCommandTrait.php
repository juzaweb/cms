<?php

namespace Juzaweb\Traits;

use Juzaweb\Exceptions\FileAlreadyExistException;
use Juzaweb\Support\Generators\FileGenerator;
use Juzaweb\Support\Stub;

trait ModuleCommandTrait
{
    /**
     * Get the plugin name.
     *
     * @return string
     */
    public function getModuleName()
    {
        $module = $this->argument('module');
        $module = app('plugins')->findOrFail($module);

        return $module->getName();
    }

    protected function makeFile($path, $contents)
    {
        try {
            $overwriteFile = $this->hasOption('force') ? $this->option('force') : false;
            (new FileGenerator($path, $contents))
                ->withFileOverwrite($overwriteFile)
                ->generate();

            $this->info("Created : {$path}");
        } catch (FileAlreadyExistException $e) {
            $this->error("File : {$path} already exists.");
        }
    }

    protected function stubRender($file, $data)
    {
        return (new Stub('/' . $file, $data))->render();
    }
}
