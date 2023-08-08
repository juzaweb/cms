<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Backend\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class ReadingSettingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'show_on_front' => 'required|string|in:posts,page',
            'home_page' => 'required_if:show_on_front,page',
            'post_page' => 'string|nullable',
        ];
    }
}
