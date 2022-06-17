<?php


namespace Juzaweb\CMS\Extension;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

/**
 * Add 'app' and all global variables shared through View::share
 */
class Globals extends AbstractExtension implements GlobalsInterface
{

    public function getGlobals(): array
    {
        return app('view')->getShared();
    }
}
