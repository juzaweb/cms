<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\Module;

use Illuminate\Foundation\Http\FormRequest;

class ActivateByCodeRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'key' => [
                'bail',
                'required',
                'string',
                'uuid'
            ],
            'module' => [
                'bail',
                'required',
                'string',
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'key.uuid' => 'The :attribute must be a valid.'
        ];
    }
}
