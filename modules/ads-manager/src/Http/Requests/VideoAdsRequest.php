<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 */

namespace Juzaweb\Modules\AdsManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VideoAdsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'name' => ['required', 'max:250'],
			'title' => ['required', 'max:250'],
			'url' => ['required', 'max:250'],
			'video' => ['required', 'max:500'],
			'position' => ['required'],
			'offset' => ['required', 'integer', 'min:0'],
			'active' => ['required', 'boolean'],
		];
    }
}
