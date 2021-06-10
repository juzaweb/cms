<?php

declare(strict_types=1);

namespace Mymo\Module\Commands;

use Illuminate\Console\Command;
use Mymo\Module\Contracts\RepositoryInterface;
use Mymo\Module\Module;

class LaravelModulesV6Migrator extends Command
{
    protected $name = 'plugin:v6:migrate';
    protected $description = 'Migrate plugins v5 modules statuses to v6.';

    public function handle() : int
    {
        $moduleStatuses = [];
        /** @var RepositoryInterface $modules */
        $modules = $this->laravel['modules'];

        $modules = $modules->all();
        /** @var Module $module */
        foreach ($modules as $module) {
            if ($module->json()->get('active') === 1) {
                $module->enable();
                $moduleStatuses[] = [$module->getName(), 'Enabled'];
            }
            if ($module->json()->get('active') === 0) {
                $module->disable();
                $moduleStatuses[] = [$module->getName(), 'Disabled'];
            }
        }
        $this->info('All modules have been migrated.');
        $this->table(['Module name', 'Status'], $moduleStatuses);

        return 0;
    }
}
