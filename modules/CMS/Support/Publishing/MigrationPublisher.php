<?php

namespace Juzaweb\CMS\Support\Publishing;

use Juzaweb\CMS\Support\Migrations\Migrator;

class MigrationPublisher extends AssetPublisher
{
    /**
     * @var Migrator
     */
    private $migrator;

    /**
     * MigrationPublisher constructor.
     * @param Migrator $migrator
     */
    public function __construct(Migrator $migrator)
    {
        $this->migrator = $migrator;
        parent::__construct($migrator->getModule());
    }

    /**
     * Get destination path.
     *
     * @return string
     */
    public function getDestinationPath()
    {
        return $this->repository->config('paths.migration');
    }

    /**
     * Get source path.
     *
     * @return string
     */
    public function getSourcePath()
    {
        return $this->migrator->getPath();
    }
}
