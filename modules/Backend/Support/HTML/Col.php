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

use Juzaweb\Backend\Support\HTML\Traits\InputElement;

class Col extends ElementBuilder
{
    use InputElement;

    public function __construct()
    {
        $this->item = ['type' => 'col'];
    }
}
