<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\Backend\Support\HTML\Traits;

use Juzaweb\Backend\Support\HTML\Field;
use Juzaweb\CMS\Models\Model;

trait UseInputElement
{
    public function addField(string|Model $label, string $name = null): Field
    {
        return new Field($label, $name, $this->item['children']);
    }
}
