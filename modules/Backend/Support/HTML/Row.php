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
        $this->item = ['type' => 'row', 'options' => []];
    }

    public function addCol1($callback): static
    {
        return $this->addCol($callback, 1);
    }

    public function addCol2($callback): static
    {
        return $this->addCol($callback, 2);
    }

    public function addCol3($callback): static
    {
        return $this->addCol($callback, 3);
    }

    public function addCol4($callback): static
    {
        return $this->addCol($callback, 4);
    }

    public function addCol5($callback): static
    {
        return $this->addCol($callback, 5);
    }

    public function addCol6($callback): static
    {
        return $this->addCol($callback, 6);
    }

    public function addCol7($callback): static
    {
        return $this->addCol($callback, 7);
    }

    public function addCol8($callback): static
    {
        return $this->addCol($callback, 8);
    }

    public function addCol9($callback): static
    {
        return $this->addCol($callback, 9);
    }

    public function addCol10($callback): static
    {
        return $this->addCol($callback, 10);
    }

    public function addCol11($callback): static
    {
        return $this->addCol($callback, 11);
    }

    public function addCol12($callback): static
    {
        return $this->addCol($callback, 12);
    }

    public function addCol($callback, int $cols = null): static
    {
        $col = new Col();

        if ($cols) {
            $col->setOption('col', $cols);
        }

        $callback($col);

        $this->item['children'][] = $col->toArray();

        return $this;
    }
}
