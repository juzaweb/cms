<?php

namespace Juzaweb\CMS\Traits;

trait MigrationLoaderTrait
{
    /**
     * Include all migrations files from the specified plugin.
     *
     * @param string $module
     */
    protected function loadMigrationFiles($module)
    {
        $path = $this->laravel['plugins']->getModulePath($module) . $this->getMigrationGeneratorPath();

        $files = $this->laravel['files']->glob($path . '/*_*.php');

        foreach ($files as $file) {
            $this->laravel['files']->requireOnce($file);
        }
    }

    /**
     * Get migration generator path.
     *
     * @return string
     */
    protected function getMigrationGeneratorPath()
    {
        return $this->laravel['plugins']->config('paths.generator.migration');
    }
}
