<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     The Anh Dang <dangtheanh16@gmail.com>
 * @link       https://juzaweb.com/cms
 * @license    MIT
 */

namespace Juzaweb\CMS\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'email' => 'bail|required|email|max:150',
            'password' => 'bail|required|min:6|max:32',
        ];

        if (get_config('google_recaptcha')) {
            $rules['recaptcha'] = 'bail|required|recaptcha';
        }

        return $rules;
    }
}
