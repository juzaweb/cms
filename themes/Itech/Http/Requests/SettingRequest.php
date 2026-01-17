<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itech\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'home_page' => ['nullable', 'string', 'uuid', 'exists:pages,id'],
            'footer_logo' => 'nullable|string|max:255',
            'footer_description' => 'nullable|string|max:255',
            'social_facebook' => 'nullable|string|max:255',
            'social_x' => 'nullable|string|max:255',
            'social_skype' => 'nullable|string|max:255',
            'social_instagram' => 'nullable|string|max:255',
            'social_youtube' => 'nullable|string|max:255',
            'social_linkedin' => 'nullable|string|max:255',
        ];
    }
}
