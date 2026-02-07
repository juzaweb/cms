<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://cms.juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Modules\AdsManagement\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\Modules\AdsManagement\Facades\Ads;

class BannerAdRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'type' => ['required', 'in:html,image'],
            'body_image' => [Rule::requiredIf($this->input('type') === 'image')],
            'body_html' => [Rule::requiredIf($this->input('type') === 'html')],
            'url' => [Rule::requiredIf($this->input('type') === 'image'), 'url', 'max:255'],
            'active' => ['required', 'in:0,1'],
            'position' => ['required', 'max:50', Rule::in(Ads::bannerPositions()->keys())],
        ];
    }
}
