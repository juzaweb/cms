<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 * @license    GNU V2
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

        if (get_config('captcha')) {
            $rules['g-recaptcha-response'] = 'bail|required|recaptcha';
        }

        return $rules;
    }
}
