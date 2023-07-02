<?php

namespace Juzaweb\CMS\Repositories\Interfaces;

interface WithAppendSearch
{
    public function appendCustomSearch($builder, $keyword, $input);
}
