<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Support\HTML;

class Row extends ElementBuilder
{
    public function __construct()
    {
        $this->item = ['type' => 'row'];
    }

    public function addCol3($callback): static
    {
        return $this->addCol(3, $callback);
    }

    public function addCol(int $cols, $callback): static
    {
        $col = new Col();

        $callback($col);

        $this->item['children'][] = $col->toArray();

        return $this;
    }
}
