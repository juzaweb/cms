<?php

namespace Mymo\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * @package Mymo\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
