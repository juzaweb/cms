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
use Juzaweb\CMS\Models\Model;

class Field extends ElementBuilder
{
    use HasOption;

    public ?array $elements;

    protected int $elementIndex = 0;

    public function __construct(
        string|Model $label,
        string $name = null,
        ?array &$elements = []
    ) {
        $this->item = [
            'type' => 'text',
            'name' => $name,
            'label' => $label
        ];

        if ($label instanceof Model) {
            $this->item['label'] = $label->attributeLabel($name);
        }

        if ($elements) {
            $this->elementIndex = count($elements);
        }

        $this->elements = &$elements;

        $this->elements[$this->elementIndex] = $this->item;
    }

    public function textInput(array $args = [])
    {
        $this->item['type'] = 'text';

        $this->elements[$this->elementIndex] = $this->item;
    }

    public function textarea(array $args = [])
    {
        $this->item['type'] = 'textarea';

        $this->elements[$this->elementIndex] = $this->item;
    }

    public function editor(array $args = [])
    {
        $this->item['type'] = 'editor';

        $this->elements[$this->elementIndex] = $this->item;
    }
}
