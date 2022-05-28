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

use Illuminate\Support\Arr;
use Juzaweb\Backend\Support\HTML\Traits\HasOption;
use Juzaweb\Backend\Support\HTML\Traits\UseInputElement;

class Card extends ElementBuilder
{
    use UseInputElement, HasOption;

    public function __construct()
    {
        $this->item = ['type' => 'card'];
    }

    public function setHeaderTitle(string $title): static
    {
        Arr::set($this->item, 'options.header_title', $title);

        return $this;
    }
}
