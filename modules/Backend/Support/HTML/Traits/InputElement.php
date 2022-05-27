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

trait InputElement
{
    public function addTextField(string $label, string $name = null, array $arg = []): static
    {
        $this->item['children'][] = [
            'type' => 'text',
            'name' => $name,
            'label' => $label
        ];

        return $this;
    }

    public function addTextareaField(string $label, string $name = null, array $arg = []): static
    {
        $this->item['children'][] = [
            'type' => 'textarea',
            'name' => $name,
            'label' => $label
        ];

        return $this;
    }
}
