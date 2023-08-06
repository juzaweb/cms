<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\DevTool\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostTypeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => ['required', 'string'],
            'label' => ['required', 'string'],
            'show_in_menu' => ['nullable', 'numeric', 'in:0,1'],
            'description' => ['nullable', 'string', 'max:250'],
            'support' => ['nullable', 'array'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge(['show_in_menu' => (int) $this->input('show_in_menu', 0)]);
    }
}
