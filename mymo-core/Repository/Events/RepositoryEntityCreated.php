<?php

namespace Tadcms\Repository\Events;

/**
 * Class RepositoryEntityCreated
 * @package Tadcms\Repository\Events
 * @author Anderson Andrade <contato@andersonandra.de>
 */
class RepositoryEntityCreated extends RepositoryEventBase
{
    /**
     * @var string
     */
    protected $action = "created";
}
