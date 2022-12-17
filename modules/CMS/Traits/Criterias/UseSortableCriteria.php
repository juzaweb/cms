<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    GNU General Public License v2.0
 */

namespace Juzaweb\CMS\Traits\Criterias;

trait UseSortableCriteria
{
    public function getFieldSortable(): array
    {
        return $this->sortableFields ?? [];
    }
    
    public function getSortableDefaults(): array
    {
        return $this->sortableDefaults ?? [];
    }
}
