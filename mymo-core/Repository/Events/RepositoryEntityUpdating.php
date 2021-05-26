<?php
namespace Tadcms\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Tadcms\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityUpdating extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updating";
}
