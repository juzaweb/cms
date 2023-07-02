<?php

namespace Juzaweb\CMS\Repositories\Interfaces;

interface SortableInterface
{
    public function withSorts(array $sorts): static;

    public function getFieldSortable(): array;

    public function getSortableDefaults(): array;
}
