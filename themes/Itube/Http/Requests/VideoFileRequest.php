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

class VideoFileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'path' => ['required'],
            'source' => ['required'],
            'quality' => ['required'],
            'storage' => ['required'],
            'video_id' => ['required', 'exists:videos'],
        ];
    }

    public function authorize()
    {
        return true;
    }
}
