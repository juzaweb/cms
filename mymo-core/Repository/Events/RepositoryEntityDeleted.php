<?php
namespace Mymo\Repository\Events;

/**
 * Class RepositoryEntityDeleted
 * @package Mymo\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityDeleted extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "deleted";
}
