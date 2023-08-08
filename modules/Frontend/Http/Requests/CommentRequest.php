<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CommentRequest extends FormRequest
{
    public function rules(): array
    {
        if (Auth::check()) {
            $rules = [
                'content' => 'required|max:300',
            ];
        } else {
            $rules = [
                'name' => 'required|max:100',
                'email' => 'required|email|max:100',
                'content' => 'required|max:300',
            ];
        }

        if (get_config('captcha')) {
            $rules['g-recaptcha-response'] = 'bail|required|recaptcha';
        }

        return $rules;
    }
}
