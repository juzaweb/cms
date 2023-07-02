<?php

namespace Juzaweb\CMS\Repositories\Interfaces;

interface WithAppendFilter
{
    public function appendCustomFilter($builder, $input);
}
