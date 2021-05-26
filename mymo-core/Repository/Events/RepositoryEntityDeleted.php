<?php
namespace Tadcms\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Tadcms\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
