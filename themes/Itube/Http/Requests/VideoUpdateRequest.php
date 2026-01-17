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
use Illuminate\Validation\Rule;
use Juzaweb\Modules\Core\Rules\AllExist;
use Juzaweb\Modules\VideoSharing\Enums\VideoMod;

class VideoUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'mode' => ['required', 'string', Rule::in(VideoMod::getValues())],
            'thumbnail' => ['required', 'array'],
            'thumbnail.path' => ['required', 'string'],
            'thumbnail.disk' => ['required', 'string', Rule::in(['tmp', 'public'])],
            'playlists' => ['nullable', 'array', AllExist::make('playlists', 'id')],
            'playlists.*' => ['integer'],
        ];
    }

    public function attributes(): array
    {
        return [
            'thumbnail.path' => __('itube::translation.thumbnail'),
            'thumbnail.disk' => __('itube::translation.thumbnail'),
        ];
    }
}
