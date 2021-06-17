<?php
namespace Mymo\Repository\Events;

/**
 * Class RepositoryEntityUpdated
 * @package Mymo\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityUpdating extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "updating";
}
