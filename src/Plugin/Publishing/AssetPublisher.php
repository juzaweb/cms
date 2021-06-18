<?php

namespace Mymo\Plugin\Publishing;

use Mymo\Plugin\Support\Config\GenerateConfigReader;

class AssetPublisher extends Publisher
{
    /**
     * Determine whether the result message will shown in the console.
     *
     * @var bool
     */
    protected $showMessage = false;

    /**
     * Get destination path.
     *
     * @return string
     */
    public function getDestinationPath()
    {
        return $this->repository->assetPath($this->module->getLowerName());
    }

    /**
     * Get source path.
     *
     * @return string
     */
    public function getSourcePath()
    {
        return $this->getModule()->getExtraPath(
            GenerateConfigReader::read('assets')->getPath()
        );
    }
}
