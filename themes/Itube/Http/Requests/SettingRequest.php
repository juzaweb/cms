<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Themes\Itube\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'home_page' => ['nullable', 'string', 'uuid', 'exists:pages,id'],
            'footer_logo' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:20',
            'contact_address' => 'nullable|string|max:500',
            ...collect(config('itube.socials', []))->mapWithKeys(
                function ($social) {
                    return ["social_{$social}" => 'nullable|string|max:255'];
                }
            )->toArray(),
        ];
    }
}
