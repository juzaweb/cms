<?php

namespace Juzaweb\CMS\Repositories\Events;

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
