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

class LoginJuzaWebRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'email' => [
                'bail',
                'required',
                'string',
                'email'
            ],
            'password' => [
                'bail',
                'required',
                'string',
            ],
        ];
    }
}
