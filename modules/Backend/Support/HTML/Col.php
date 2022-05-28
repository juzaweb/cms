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

use Juzaweb\Backend\Support\HTML\Traits\HasOption;
use Juzaweb\Backend\Support\HTML\Traits\UseInputElement;

class Col extends ElementBuilder
{
    use UseInputElement, HasOption;

    public function __construct(int $col = null)
    {
        $this->item = ['type' => 'col', 'col' => $col];
    }
}
