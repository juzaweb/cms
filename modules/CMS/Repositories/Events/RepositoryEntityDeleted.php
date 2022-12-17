<?php

namespace Juzaweb\CMS\Repositories\Events;

use Juzaweb\CMS\Repositories\Events\RepositoryEventBase;

/**
 * Class RepositoryEntityDeleted
 *
 * @package Prettus\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
