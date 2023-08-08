<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/cms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Backend\Http\Requests\Theme;

use Illuminate\Foundation\Http\FormRequest;

class EditorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'file' => 'required',
            'content' => 'required|string|max:10000',
        ];
    }
}
